<?php

namespace App\Http\Controllers\Api;

use App\Actions\Panel\User\ChangeUserAction;
use App\Actions\Panel\User\DeleteUserAction;
use App\Actions\Panel\User\IndexUserAction;
use App\Actions\Panel\User\ResetUserAction;
use App\Actions\Panel\User\StoreUserAction;
use App\Actions\Panel\User\UpdateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Response;

class UserController extends Controller
{
    public function __construct()
    {
        Gate::authorize('admin');
    }


    public function index(IndexUserAction $action, Request $request)
    {

        $result = $action->handle($request);

        return Response::json([

            'users' => UserCollection::make($result['users'])
        ]);
    }


    public function store(StoreUserAction $action, StoreUserRequest $request)
    {
        $data = $request->validated();
        $result = $action->handle($data);

        return Response::json(
            [
                'user' => UserResource::make($result['user']),
                'message' => "user ` {$result['user']->fullName} ` has been created. ",
            ]
        );
    }

    public function update(User $user, UpdateUserRequest $request, UpdateUserAction $action)
    {
        $data = $request->validated();
        $result = $action->handle($data , $user);

        return Response::json([

                "user" => UserResource::make($result['user']),
                "message" => "user `{$user->FullName}` has many posts. and are you not allowad to Updated "
            ]); }

    public function destroy(DeleteUserAction $action, User $user)
    {
        $result = $action->handle($user);

        if (!$result['status']) {
            return Response::json([

                "user" => UserResource::make($result['user']),
                "message" => "user `{$user->FullName}` has many posts. and are you not allowad to delete "
            ]);
        } else {
            return Response::json([

                "user" => UserResource::make($result['user']),
                "message" => "user `{$user->FullName}` has many posts. and are you not allowad to delete "
            ]);
        }
    }


    public function change(ChangeUserAction $action, User $user)
    {
        $action->handle($user);

        return Response::json([

            "user" => UserResource::make($user),
            "message" => "user `{$user->FullName}` has many posts. and are you not allowad to changed "
        ]);
    }

    public function reset(ResetUserAction $action , User $user)
    {

        $action->handle($user);

        return Response::json([

            "user" => UserResource::make($user),
            "message" => "user `{$user->FullName}` has been rested "
        ]);
    }
}
