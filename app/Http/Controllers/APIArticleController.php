<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\Resp;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;

class APIArticleController extends Controller
{
   public function articles(Request $request)
   {
      try{
         $query = Article::query();
   
         // Search in title or description
         if ($request->has('q') && !empty($request->q)) {
            $query->where(function ($subQuery) use ($request) {
               $searchTerm = strtolower($request->q);
               $subQuery->whereRaw('MATCH(title, description) AGAINST(? IN BOOLEAN MODE)', [$searchTerm]);
            });
         }
   
         // Filter by date
         if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('date', $request->date);
         }

         // Filter by author
         if ($request->has('author') && !empty($request->author)) {
            $query->where('author', $request->author);
         }
         
         // Filter by category
         if ($request->has('category') && !empty($request->category)) {
            $query->where('category', $request->category);
         }
   
         // Filter by source
         if ($request->has('source') && !empty($request->source)) {
            $query->where('source', $request->source);
         }

         $data_table = self::data_table($query, ['id','news_api', 'news_id', 'url', 'date', 'category', 'source', 'author', 'title', 'description']);
         unset($data_table['draw']);
         unset($data_table['recordsFiltered']);
         $data_table['succss'] = true;
         $data_table['data'] = new ArticleCollection($data_table['data']);
         return response()->json($data_table);
      } catch (\Exception $ex) {
         return Resp::catchErrorAPI($ex);
      }
   }

   public function sources()
   {
      try{
         return response()->json([
            ['id' => 'NewsOrg', 'name' => 'News API'],
            ['id' => 'TheGuardian', 'name' => 'The Guardian'],
            ['id' => 'NYTimes', 'name' => 'The New York Times'],
         ]);
      } catch (\Exception $ex) {
         return Resp::catchErrorAPI($ex);
      }
   }
}
