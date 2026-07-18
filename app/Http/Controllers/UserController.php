<?php

namespace App\Http\Controllers;

use App\Actions\Panel\User\ChangeUserAction;
use App\Actions\Panel\User\DeleteUserAction;
use App\Actions\Panel\User\IndexUserAction;
use App\Actions\Panel\User\ResetUserAction;
use App\Actions\Panel\User\StoreUserAction;
use App\Actions\Panel\User\UpdateUserAction;
use App\Enums\UserRoleEnum;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserCollection;
use App\Mail\SendPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class UserController extends Controller
{

    public function __construct()
    {
        Gate::authorize('admin');
    }

    public function index(IndexUserAction $action, Request $request)
    {

        $result = $action->handle($request);

        return View::make('admins.user.index', [

            'users' => $result['users']
        ]);
    }

    public function create()
    {
        return View::make('admins.user.create');
    }

    public function store(StoreUserAction $action, StoreUserRequest $request)
    {
        $data = $request->validated();
        $result = $action->handle($data);

        return redirect()
            ->route('user.index')
            ->with('message', "user `{$result['user']->FullName}` has been Created");
    }

    public function destroy(DeleteUserAction $action, User $user)
    {
        $result = $action->handle($user);

        if (!$result['status']) {
            return redirect()->back()
                ->with('message', "user `{$user->FullName}` has many posts. and are you not allowad to delete ");
        } else {
            return redirect()->back()
                ->with('message', "user `{$user->FullName}` has been deleted ");
        }
    }

    public function edit(User $user)
    {
        return View::make('admins.user.edit', [
            'user' => $user
        ]);
    }

    public function update(User $user, UpdateUserRequest $request, UpdateUserAction $action)
    {
        $data = $request->validated();
        $result = $action->handle($data , $user);

        return redirect()
            ->route('user.index')
            ->with('message', "user `{$result['user']->FullName}` has been Update");
    }

    public function change(ChangeUserAction $action, User $user)
    {
        $action->handle($user);

        return redirect()
            ->back()
            ->with('message', "User {$user->FullName} has been changed. ");
    }

    public function reset(ResetUserAction $action  , User $user)
    {

        $action->handle($user);
      
        return redirect()->back()->with('message', "user {$user->FullName} has been reset");
    }
}
