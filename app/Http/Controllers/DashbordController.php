<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class DashbordController extends Controller
{
    public function dashbord(){
        return View::make('admins.dashbord') ;
    }
}
