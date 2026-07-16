<?php

namespace App\Http\Controllers\Api;

use App\Actions\Auth\AuthenticateAction;
use App\Actions\Auth\RegisterUserAction;
use App\Actions\Auth\UpdateProfileAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthenticateUserRequest;
use App\Http\Requests\Auth\RegisterUserRequeset;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function authenticate(AuthenticateAction $action, AuthenticateUserRequest $request)
    {

        $data = $request->validated();

        $throttlekey = Str::lower($request->input('email')) . '|' . $request->ip();

        $result = $action->handle($data, $throttlekey, $request);

        return Response::json([
            'token' => $result['token'],
            'user' => UserResource::make($result['user'])
        ]);
    }

    public function register(RegisterUserAction $action , RegisterUserRequeset $request)
    {
        $data = $request->validated();
        $action->handle($data ,$request);
        
        return Response::json([
            'status' => true ,
            'message' => ['you are Register in Website']
        ]);
    }

    public function me(){
        $user = Auth::user() ;

        return Response::json([
            'data' => UserResource::make($user) ,
        ]);
    }

    public function logout(Request $request){

        // Auth::user()->currentAccessToken()->delete();
        $request->user()->currentAccessToken()->delete();

        return Response::json([
            'status' => true ,
            'message' => ['you are logout from Website']
        ]);
    }

    public function updateprofile(UpdateProfileAction $action ,UpdateProfileRequest $request,)
    {
        $data = $request->validated();

        $result =  $action->handle($data);
       
        return  Response::json([
            "status" => true ,
            "user" => UserResource::make($result['user']),
            'message' => ['you Profile has been Updated']
        ]);
    }
}
