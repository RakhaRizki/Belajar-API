<?php

namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class PostResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'image' => $this->image,
            'writer' => $this->writer('username'),
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s'),
            'total_comments' => $this->comments->count(),
            'comments' => CommentsResource::collection($this->comments),
        ];
    }
    
}
