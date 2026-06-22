<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Intervention\Image\ImageManager;

class ResizeAvatarJob implements ShouldQueue
{
    use Queueable;
    private User $user ; 

    public function __construct(User $user) {
        $this->user = $user ;
    }

    public function handle(): void
    {
     $avatar = public_path($this->user->avatar);
     $image = ImageManager::gd()->read($avatar);
     $image->resize(200,200);
     $image->save(storage_path('app/public/avatar/' . md5($this->user->email).'.png'));
    }
}
