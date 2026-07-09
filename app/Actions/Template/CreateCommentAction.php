<?php 

namespace App\Actions\Template;

use App\Enums\CommentStatusEnum;
use App\Models\Post;
use App\Models\User;
use App\Notifications\CommentNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class CreateCommentAction{
    public function handle(string $slug,array $data ,string $throttlekey ): array{


        if (RateLimiter::tooManyAttempts($throttlekey, 2)) {
            throw ValidationException::withMessages([
                'name' => [__('too many login attempts . please try again in :seconds seconds. ', [
                    'seconds' => RateLimiter::availableIn($throttlekey)
                ])],
            ]);
        }

        RateLimiter::hit($throttlekey, 60);


        $post = Post::where('status', true)
            ->where('slug', $slug)
            ->firstOrFail();

        $data['status'] = CommentStatusEnum::PENDING;

        $comment = $post->comments()->create($data);
        $user = User::find(1);
        Notification::send($user, new CommentNotification($comment));

        return [
            'comment' => $comment,
            'message' => 'Comment was posted and show after accept by admin'
        ];
    }
}