<?php

namespace App\Enums;

use ArchTech\Enums\Values;

enum UserRoleEnum :string
{
    use Values ;

    case ADMIN = 'admin' ;
    case USER = 'user' ;
}
