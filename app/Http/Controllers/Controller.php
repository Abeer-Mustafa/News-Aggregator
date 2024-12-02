<?php

namespace App\Http\Controllers;

abstract class Controller
{
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
