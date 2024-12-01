<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Carbon\Carbon;

class ArticleCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request)
    {
        return $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'news_api' => $item->news_api,
                'url' => $item->url,
                'category' => $item->category,
                'source' => $item->source,
                'author' => $item->author,
                'title' => $item->title,
                'description' => $item->description,
                // 'content' => $item->content,
                'date' => Carbon::parse($item->date)->format('Y-m-d H:i:s')
            ];
        });
    }
}
