<?php

namespace App\Traits;
use Illuminate\Http\Request;
use Log;

trait Resp
{
   public static function successResponse($result = null, $message = null, $extra_data = []){
      $response = [
         'data'    => $result,
         'success' => $message ?? 'Data saved successfuly',
      ];

      return response()->json($response, 200);
   }

   public static function errorResponse($result = null, $message = 'Internal Server Error', $code = 503){
      if($code == 404)$message = 'No data found for the requested criteria.';
      
      $response = [
         'errors'    => $result,
         'message' => $message,
      ];

      return response()->json($response, $code);
   }

   public static function catchErrorJson($ex){
      $message = method_exists($ex, 'getResponse') ? $ex->getResponse()->getBody()->getContents() : $ex->getMessage();
      Log::alert("{$message}\nFile: {$ex->getFile()}\nLine: {$ex->getLine()}");

      $data = json_decode($message, true);
      if (isset($data['message'])) {
         $message = $data['message'];
      }
      return [
         'errors'    => $message,
         'message' => $message,
      ];
   }  

   public static function catchErrorAPI($ex){
      $message = method_exists($ex, 'getResponse') ? $ex->getResponse()->getBody()->getContents() : $ex->getMessage();
      Log::alert("{$message}\nFile: {$ex->getFile()}\nLine: {$ex->getLine()}");

      $data = json_decode($message, true);
      if (isset($data['message'])) {
         $message = $data['message'];
      }
      return [
         'status' => false,
         'message' => $message,
      ];
   }  

   public static function catchErrorPage($ex){
      Log::alert($ex->getMessage().'. File: '.$ex->getFile().' Line: '.$ex->getLine());
      if (method_exists('getStatisCode', $ex)){
         $status_code = $ex->getStatusCode();
         return $status_code == 500 ? view('errors.500') : view('errors.404');
      }
      return view('errors.500');
   }  
}