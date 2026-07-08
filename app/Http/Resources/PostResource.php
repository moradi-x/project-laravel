<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        //  همه چیز رو لود میکنه در جیسون که ما نمیخوایم 

        return [
        'id' => $this->id ,
        'title' => $this->title ,
        'slug' => $this->slug,
        'status' => $this->status ? 'active' : 'inactive' ,
        'content' => $this->content,
        'thumbnail' => $this->thumbnail ,
        'created_at' => $this->created_at->format('d M Y - l'),
        'user' => $this->whenLoaded('user',$this->user->fullname) ,
        'categories' => $this->whenLoaded('categories' , CategoryResource::collection($this->categories)) 
        ];
    }
}
