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

class NYTimes implements NewsServiceInterface
{
   protected $baseUrl;
   protected $apiKey;
   protected $first_page;

   public function __construct()
   {
      $this->apiKey = config('news_api.nytimes.api-key');
      $this->baseUrl = config('news_api.nytimes.api-url');
      $this->first_page = config('news_api.nytimes.first-page');
   }

   public function getData($params = []): array
   {
      try {
         if(isset($params['begin_date'])){
            $begin_date = str($params['begin_date'])->replace('-', '');
            $this->baseUrl .= "&begin_date={$begin_date}";
         }
         if(isset($params['end_date'])){
            $end_date = str($params['end_date'])->replace('-', '');
            $this->baseUrl .= "&end_date={$end_date}";
         }
         if(isset($params['fq'])){
            $this->baseUrl .= "&fq=section_name:(";
            foreach ($params['fq'] as $key => $fq) {
               $this->baseUrl .= ('"' .$fq.'"');
               if($key < count($params['fq'])-1){
                  $this->baseUrl .= ',';
               }
            }
            $this->baseUrl .= ")";
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
               sleep(10);
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
         $today = str($today)->replace('-', '');
         $url .= "&begin_date={$today}";
         $url .= "&end_date={$today}";

         $result = $this->makeRequest($url);
         if(isset($result['articles'])){
            $total = $result['total'];
            $articles = $result['articles'];
            $last_index = $result['last_index'];

            // total changed
            $currentTotal = config('news_api.nytimes.today_count');
            if($total > $currentTotal){
               config(['news_api.nytimes.today_count' => $total]);
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
               Article::updateOrCreate(['news_id'=> $article->_id,'news_api' => 'NYTimes'], [
                  'news_api' => 'NYTimes',
                  'news_id' => $article->_id,
                  'url' => $article->web_url,
                  'date' => Carbon::parse($article->pub_date)->format('Y-m-d H:i:s'),
                  'category' => isset($article->section_name) ? $article->section_name : null,
                  'source' => isset($article->source) ? $article->source : null,
                  'author' => isset($article->byline) && isset($article->byline->original) ? str($article->byline->original)->replace('By ', '') : null,
                  'title' => isset($article->headline) && isset($article->headline->main) ? $article->headline->main : null,
                  'description' => isset($article->abstract) ? $article->abstract : null,
                  // 'content' => isset($article->lead_paragraph) ? $article->lead_paragraph : null,
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
         $result = json_decode($client->request("GET",  $url)->getBody());

         $articles = $result->response->docs;
         $total = $result->response->meta->hits;
         $page_size = config('news_api.nytimes.page-size');
         $quotient = intdiv($total, $page_size);
         $remainder = $total % $page_size;
         $last_index = $quotient + ($remainder > 0 ? 1 : 0) - 1;

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
