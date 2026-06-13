<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ResizeAvatarJob implements ShouldQueue
{
    use Queueable;



    public function __construct() {
        
    }

    public function handle(): void
    {
        
    }
}
