<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum CommentStatusEnum :string
{
    use Values ;
    case ACCEPT = 'accept' ;
    case PENDING = 'pending' ;
    case BLOCK = 'block';
}

