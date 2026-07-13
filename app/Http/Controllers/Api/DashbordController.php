<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class DashbordController extends Controller
{
    public function dashbord(){
        return Response::json([
            'status' => true ,
            'messages' => "You adre loggid in."
        ]) ;
    }
}
