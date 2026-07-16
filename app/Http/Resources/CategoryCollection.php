<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CategoryCollection extends ResourceCollection
{

    public function toArray(Request $request): array
    {
        return [
            'data' => CommentResource::collection($this->collection),

            'meta' => [
                'current_page' => $this->currentPage(),
                'total' => $this->total(),
                'per_page' => $this->perPage(),
                'last_page' => $this->lastPage()
            ]
        ];
    }
}
