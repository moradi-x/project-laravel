<?php

namespace App\Models;

use App\Enums\CommentStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'comment',
        'status',
        'post_id'
    ];


    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class)->withTrashed();
    }


    protected $casts = [
        'status' => CommentStatusEnum::class

    ];

    public function isAccept()
    {
        return  $this->status == CommentStatusEnum::ACCEPT;
    }

    public function isBlock()
    {
        return  $this->status == CommentStatusEnum::BLOCK;
    }

    public function isPending()
    {
        return  $this->status == CommentStatusEnum::PENDING;
    }
}
