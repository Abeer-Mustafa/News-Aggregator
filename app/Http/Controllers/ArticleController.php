<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Resources\ArticleCollection;
use App\Http\Requests\BrandRequest;
use App\Traits\Resp;

use App\Services\NewsOrg;
use App\Services\NYTimes;
use App\Services\TheGuardian;

use App\Models\Article;

class ArticleController extends Controller
{
   protected $NewsOrgService;
   protected $NYTimesService;
   protected $TheGuardianService;

   public function __construct(NewsOrg $NewsOrgService, NYTimes $NYTimesService, TheGuardian $TheGuardianService)
   {
      $this->NewsOrgService = $NewsOrgService;
      $this->NYTimesService = $NYTimesService;
      $this->TheGuardianService = $TheGuardianService;
   }

   // get all records
   public function index(){
      if(request()->ajax())
      {
         $query = Article::query();
         $data_table = self::data_table($query, ['id','news_api', 'news_id', 'url', 'date', 'category', 'source', 'author', 'title', 'description']);
         $data_table['data'] = new ArticleCollection($data_table['data']);
         return response()->json($data_table);
      }

      return view('welcome');
   }

   // fetch news
   public function fetch_news(Request $request)
   {
      $service = $this->{$request->service};
      $data = $service->getData($request->all());

      if(isset($data['errors'])){
         return Resp::errorResponse($data['errors']);
      }
      if($data['total'] > 0){
         return Resp::successResponse([], "<strong>{$data['total']}</strong> articles are currently being stored. Please wait...");
      }
      return Resp::errorResponse([], null, 404);
   }
}
