<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id ,
            'name' => $this->name,
            'family' => $this->family,
            'fullName' => $this->fullName,            
            'email' => $this->email,
            'status' => $this->status ? 'active' : 'inactive',
            'role' => $this->role,
            'avatar' =>asset($this->avatar),
            'created_at' => $this->created_at->format('d M Y - l'),

        ];
    }
}
