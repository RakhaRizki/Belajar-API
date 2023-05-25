<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;



class CommentsResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'comments_content' => $this->comments_content,
            'comentator' => $this->comentator['username'],
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s')
        ];
    }
}
