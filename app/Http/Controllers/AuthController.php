<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Jobs\ResizeAvatarJob;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{

    public function login(Request $request)
    {
        return view::make('authenticates.login');
    }

    public function authenticate(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'min:6', 'string']
        ]);

        if (!Auth::attempt($data)) {
            // ایمبل و رمز رو در دیتا بیس چک میکنه درست بود در سشن اجازه لاگین میده
            throw ValidationException::withMessages([
                'email' => ['Invalid credential'],
                // قرمز ارور بده که همچین کاربری نداریم
            ]);
        }

        $user = Auth::user();

        if (!$user->status) {
            //  اگر استاتوس کاربر فالس هست لاگ اوتش کن
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['your accent id inactive'],
            ]);
        }

        return Redirect::route('dashbord');
        // ریدایرکت کرده چون میخواد به کنترل هایی دیگه در اون روت بره نه اینکه فقط اینجا ویو میک کنه
    }

    public function register()
    {
        return View::make('authenticates.register');
    }

    public function registerUser(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3 , max:50'],
            'family' => ['required', 'string', 'min:3 , max:50'],
            'email' => ['required', 'email', 'string', 'unique:users', 'max:100'],
            'password' => ['required', 'string', 'min:6, max:100', 'confirmed'],
        ]);
        $data['status'] = true;
        $data['role'] = UserRoleEnum::USER;

        $user = User::create($data);
        Auth::login($user);
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
 