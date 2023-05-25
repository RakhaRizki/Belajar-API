<?php

namespace App\Http\Resources;

use DateTime;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'image' => $this->image,
            'writer' => $this->whenLoaded('writer', function() {
                return $this->writer['username'];
            }),
            'created_at' => date_format ($this->created_at, 'Y-m-d H:i:s'),
            'total_comments' => $this->comments->count(),
            'comments' => CommentsResource::collection($this->comments),
        ];
    }
}
