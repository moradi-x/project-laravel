<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CommentCollection extends ResourceCollection
{
    
    public function toArray(Request $request): array
    {
        return [
            
            'data' => CategoryResource::collection($this->collection),

            'meta' => [
                'current_page' => $this->currentPage(),
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'last_page' => $this->lastPage()
            ]
        ];
    }
}
