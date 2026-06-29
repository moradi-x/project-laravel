<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentNotification extends Notification
{
    use Queueable;
    private Comment $comment ;
    
    public function __construct(Comment $comment)
    {
        $this->comment = $comment ;
    }

  
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    
    public function toArray(object $notifiable): array
    {
        return [
            'email' => $this->comment->email ,
            'naem' => $this->comment->name ,
            'message' => "user {$this->comment->name} send a comment." ,
        ];
    }
}
