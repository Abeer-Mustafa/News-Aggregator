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

   // datatable
   public function data_table($query, $search_columns = [], $default_order = 'created_at', $dir_order="desc"){
      $draw = request()->get('draw');
      $start = request()->input('start', 0);
      $length = request()->input('length', 10);
   
      $search = request()->search ?? [] ;
      $order = request()->order ?? [] ;
   
      if(count($order) > 0 && isset($order[0]['column']) && $order[0]['column'] != '0'){
         $column_index = $order[0]['column'];
         $column_name = request()->columns[$column_index]['name'];
         $query->orderBy($column_name, $order[0]['dir']);
      }
      else{
         $query->orderBy($default_order, $dir_order);
      }
      
      if(count($search) > 0 && $search['value'] != '' && count($search_columns) > 0){
         $query->whereAny($search_columns, 'LIKE', '%' . $search['value'] . '%');
      }
      
      $total = $query->count();
   
      if($length > 0){
         $query->offset($start)->limit($length);
      }
      $data = $query->get();
      
      return [
         'draw' => intval($draw),
         'recordsTotal' => $total,
         'recordsFiltered' => $total,
         'data' => $data,
      ];
   }
}
