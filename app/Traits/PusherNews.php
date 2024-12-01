<?php

namespace App\Traits;
use Pusher\Pusher;

trait PusherNews
{
   public static function triggerEventNews(){
      $options = array(
         'cluster' => config('pusher.cluster'),
         'useTLS' => true,
         'time' => time(),
      );
      $pusher = new Pusher(
         config('pusher.key'),
         config('pusher.secret'),
         config('pusher.id'),
         $options
      );
   
      $pusher->trigger('new-articles', 'App\\Events\\NewsUpdatedEvent', 'New articles have been added.');
   }

}