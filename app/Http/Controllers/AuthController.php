<?php

namespace App\Http\Controllers;

use App\Actions\Auth\AuthenticateAction;
use App\Actions\Auth\RegisterUserAction;
use App\Enums\UserRoleEnum;
use App\Http\Requests\Auth\AuthenticateUserRequest;
use App\Http\Requests\Auth\RegisterUserRequeset;
use App\Jobs\ResizeAvatarJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {

        // dd(Auth::check(), Auth::user());

        return view::make('authenticates.login');
    }

    public function authenticate(AuthenticateAction $action, AuthenticateUserRequest $request)
    {

        $data = $request->validated();

        $throttlekey = Str::lower($request->input('email')) . '|' . $request->ip;

        $action->handle($data, $throttlekey, $request);


        return Redirect::route('dashbord');
        // ریدایرکت کرده چون میخواد به کنترل هایی دیگه در اون روت بره نه اینکه فقط اینجا ویو میک کنه
    }

    public function register()
    {
        return View::make('authenticates.register');
    }

    public function registerUser(RegisterUserAction $action , RegisterUserRequeset $request)
    {
        $data = $request->validated();
        $action->handle($data ,$request);
        
        return Redirect::route('dashbord');
    }

    public function profile()
    {
        $user = Auth::user();
        return View::make('admins.profile.edit', [
            'user' => $user
        ]);
    }

    public function updateprofile(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'family' => ['required', 'string', 'min:3', 'max:100'],
            'avatar' => ['nullable', 'image'],
            'password' => ['nullable', 'string', 'min:8', 'max:100', 'confirmed'],
        ]);
        /** @var User */

        $user = Auth::user();
        $user->name = $data['name'];
        $user->family = $data['family'];

        if (isset($data['password'])) {
            $user->password = $data['password'];
        }

        if (isset($data['avatar'])) {
            $user->avatar = 'storage/' . $data['avatar']->storeAs('avatar', md5($user->email) . '.png');

            ResizeAvatarJob::dispatch($user);
        }
        $user->save();
        return redirect()->back()->with('message', "you profile has been updated.");
    }

    public function logout()
    {

        Auth::logout();

        return Redirect::route('login');
    }
}
