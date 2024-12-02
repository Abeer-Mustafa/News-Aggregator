<?php

namespace App\Services;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Exception;
use Carbon\Carbon;

use App\View\Components\NewsOrg as NewsOrgComponent;
use App\Jobs\FetchNewsJob;
use App\Traits\PusherNews;
use App\Traits\Resp;

use App\Models\Article;

class NewsOrg implements NewsServiceInterface
{
   protected $baseUrl;
   protected $apiKey;
   protected $sources;
   protected $first_page;

   public function __construct()
   {
      $this->apiKey = config('news_api.news-org.api-key');
      $this->baseUrl = config('news_api.news-org.api-url');
      $this->first_page = config('news_api.news-org.first-page');
      $component = new NewsOrgComponent;
      $this->sources = $component->sources;
   }

   public function getData($params = []): array
   {
      try {
         if(isset($params['sources'])){
            $this->baseUrl .= "&sources={$params['sources']}";
         }
         if(isset($params['from'])){
            $this->baseUrl .= "&from={$params['from']}";
         }
         if(isset($params['to'])){
            $this->baseUrl .= "&to={$params['to']}";
         }

         $result = self::getPaginatedData($this->baseUrl, $this->first_page);

         if(isset($result['data'])){
            return [
               'data' => $result['data'],
               'total' => $result['total']
            ];
         }
         else{
            return $result;
         }

      } catch (\Exception $ex) {
         return Resp::catchErrorJson($ex);
      }
   }

   // get data for specific page
   public function getPaginatedData($main_url, $page, $maxResults = null): array
   {
      try {
         $url = "{$main_url}&page={$page}";

         $result = $this->makeRequest($url);
         if(isset($result['articles'])){
            $total = $result['total'];
            $articles = $result['articles'];
            $last_index = $result['last_index'];
            $page_size = $result['page_size'];
            $moreData = !is_null($maxResults) ? ($page * $page_size < $maxResults ? true : false) : true;

            self::storeData($articles);

            if($page < $last_index && $moreData){
               dispatch(new FetchNewsJob(self::class, $main_url, $page+1, $maxResults));
            }

            return [
               'data' => $articles,
               'total' => $total,
               'last_index' => $last_index
            ];
         }
         else{
            return $result;
         }
      } catch (\Exception $ex) {
         return Resp::catchErrorJson($ex);
      }
   }

   // get today's articles for live updates
   public function getTodayArticlesCount(): void
   {
      try {
         $url = $this->baseUrl;
         $today = Carbon::now()->format('Y-m-d');
         $url .= "&sources=abc-news";
         $url .= "&from={$today}";
         $url .= "&to={$today}";

         $result = $this->makeRequest($url);
         if(isset($result['articles'])){
            $total = $result['total'];
            $articles = $result['articles'];
            $last_index = $result['last_index'];

            // total changed
            $currentTotal = config('news_api.news-org.today_count');
            if($total > $currentTotal){
               config(['news_api.news-org.today_count' => $total]);
               dispatch(new FetchNewsJob(self::class, $url, $this->first_page, $total - $currentTotal));
            }
         }
      } catch (\Exception $ex) {
         Resp::catchErrorJson($ex);
      }
   }

   // store articles in database
   public function storeData($articles): void
   {
      try {
         if(count($articles) > 0){
            foreach ($articles as $key => $article) {
               $source = null;
               $source_id = null;
               if(isset($article->source)){
                  if(isset($article->source->id)) {
                     $source = $article->source->id; 
                     $source_id = $article->source->id; 
                  }
                  if(isset($article->source->name)) $source = $article->source->name; 
               }
               Article::updateOrCreate(['news_id'=> $article->url,'news_api' => 'NewsOrg'], [
                  'news_api' => 'NewsOrg',
                  'news_id' => $article->url,
                  'url' => $article->url,
                  'date' => Carbon::parse($article->publishedAt)->format('Y-m-d H:i:s'),
                  'category' => !is_null($source_id) ? $this->sources[$source_id]['category'] : null,
                  'source' => $source,
                  'author' => isset($article->author) ? $article->author : null,
                  'title' => isset($article->title) ? $article->title : null,
                  'description' => isset($article->description) ? $article->description : null,
                  // 'content' => isset($article->content) ? $article->content : null,
               ]);
            }
            PusherNews::triggerEventNews();
         }
      } catch (\Exception $ex) {
         Resp::catchErrorJson($ex);
      }
   }

   // make client request
   public function makeRequest($url)
   {
      try {
         $client = new Client();
         $result = json_decode($client->request("GET",  $url, [
            'headers' => [
               'Authorization' => "Bearer Token: {$this->apiKey}"
            ]
         ])->getBody());

         $articles = $result->articles;
         $total = $result->totalResults;
         $page_size = config('news_api.news-org.page-size');
         $quotient = intdiv($total, $page_size);
         $remainder = $total % $page_size;
         $last_index = $quotient + ($remainder > 0 ? 1 : 0);

         return [
            'articles' => $articles,
            'total' => $total,
            'last_index' => $last_index,
            'page_size' => $page_size
         ];

      } catch (\Exception $ex) {
         return Resp::catchErrorJson($ex);
      }
   }
}
