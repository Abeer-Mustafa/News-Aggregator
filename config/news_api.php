<?php

$nytimes_key = env('NYTIMES_API_KEY', '10RgM5N8e7rbeeYTYPG7I2PPjIH8nh14');
return [
   'news-org' => [
      'name' => App\Services\NewsOrg::class,
      'api-key' => env('NEWS_ORG_API_KEY', 'd64589e8356a4ed39e1b9f6abd161719'),
      'api-url' => "https://newsapi.org/v2/everything?sortBy=publishedAt&pageSize=10",
      'first-page' => 1,
      'page-size' => 10,
      'today_count' => 0,
   ],
   'the-guardian' => [
      'name' => App\Services\TheGuardian::class,
      'api-key' => env('THE_GUARDIAN_API_KEY', '0061ca24-ae46-4aea-a6ea-b4de95cbad75'),
      'api-url' => "https://content.guardianapis.com/search?show-fields=body,byline&order-by=newest&page-size=10",
      'first-page' => 1,
      'page-size' => 10,
      'today_count' => 0,
   ],
   'nytimes' => [
      'name' => App\Services\NYTimes::class,
      'api-key' => $nytimes_key,
      'api-url' => "https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key={$nytimes_key}&sort=newest&fl=web_url,abstract,lead_paragraph,source,pub_date,headline,section_name,byline,_id",
      'first-page' => 0,
      'page-size' => 10,
      'today_count' => 0,
   ],
];
