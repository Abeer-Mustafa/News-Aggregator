<?php

namespace App\Services;

interface NewsServiceInterface
{
   public function getData(array $params = []): array;

   public function getPaginatedData(string $mainUrl, int $page, int $maxResults = null): array;

   public function getTodayArticlesCount(): void;
   
   public function storeData(array $articles): void;
}
