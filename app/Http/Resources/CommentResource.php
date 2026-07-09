<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return[
        'id' => $this->id ,
        'name' => $this->name ,
        'emali' => $this->email ,
        'status' => $this->status ,
        'comment' => $this->comment ,
        'created_at' => $this->created_at->format('d M Y - l'),
        ];
    }
}
