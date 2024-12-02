<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ArticleCollection;
use App\Models\Article;

class ArticleController extends Controller
{
   public function articles(Request $request)
   {
      $query = Article::query();

      // Search in title or content
      if ($request->has('search') && !empty($request->search)) {
         $query->where(function ($subQuery) use ($request) {
               $subQuery->where('title', 'LIKE', '%' . $request->search . '%')
                        ->orWhere('description', 'LIKE', '%' . $request->search . '%');
                        // ->orWhere('content', 'LIKE', '%' . $request->search . '%');
         });
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
      $data_table['data'] = new ArticleCollection($data_table['data']);
      return response()->json($data_table);

      return response()->json($articles);
   }
}
