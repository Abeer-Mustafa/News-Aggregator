<?php

namespace App\Services;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Client;
use Exception;
use Carbon\Carbon;

use App\Jobs\FetchNewsJob;
use App\Traits\PusherNews;
use App\Traits\Resp;

use App\Models\Article;

class TheGuardian implements NewsServiceInterface
{
   protected $baseUrl;
   protected $apiKey;
   protected $first_page;

   public function __construct()
   {
      $this->apiKey = config('news_api.the-guardian.api-key');
      $this->baseUrl = config('news_api.the-guardian.api-url');
      $this->first_page = config('news_api.the-guardian.first-page');
   }

   public function getData($params = []): array
   {
      try {
         if(isset($params['section'])){
            $this->baseUrl .= "&section={$params['section']}";
         }
         if(isset($params['from_date'])){
            $this->baseUrl .= "&from-date={$params['from_date']}";
         }
         if(isset($params['to_date'])){
            $this->baseUrl .= "&to-date={$params['to_date']}";
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
            $currentTotal = config('news_api.the-guardian.today_count');
            if($total > $currentTotal){
               config(['news_api.the-guardian.today_count' => $total]);
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
               Article::updateOrCreate(['news_id'=> $article->id,'news_api' => 'TheGuardian'], [
                  'news_api' => 'TheGuardian',
                  'news_id' => $article->id,
                  'url' => $article->webUrl,
                  'date' => Carbon::parse($article->webPublicationDate)->format('Y-m-d H:i:s'),
                  'category' => isset($article->sectionName) ? $article->sectionName : null,
                  'source' => null,
                  'author' => isset($article->fields) && isset($article->fields->byline) ? $article->fields->byline : null,
                  'title' => isset($article->webTitle) ? $article->webTitle : null,
                  'description' => null,
                  // 'content' => isset($article->fields) && isset($article->fields->body) ? $article->fields->body : null,
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
               'api-key' => $this->apiKey
            ]
         ])->getBody());

         $articles = $result->response->results;
         $total = $result->response->total;
         $page_size = config('news_api.the-guardian.page-size');
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
