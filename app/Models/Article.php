<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $guarded = [];

    // --------- Relationships ---------
    // public function news_api() {
    //     return $this->belongsTo(NewsApi::class);
    // } 
}
