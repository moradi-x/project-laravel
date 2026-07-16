<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class  AuthenticateAction
{
    public function handle(array $data, string $throttlekey, Request $request): array
    {
        if ($request->expectsJson()) {
            $user = $this->apiAuthenticate($data, $throttlekey);

            return [
                'token' => $user->createToken('api-token')->plainTextToken,
                'user' => $user
            ];
        }

        $user = $this->WebAuthenticate($data, $throttlekey);

        return [
            'user' => $user
        ];
    }

    private function WebAuthenticate(array $data, string $throttlekey): User
    {

        if (RateLimiter::tooManyAttempts($throttlekey, 5)) {
            throw ValidationException::withMessages([
                'email' => [__('too many login attempts . please try again in :seconds seconds. ', [
                    'seconds' => RateLimiter::availableIn($throttlekey)
                ])],
            ]);
        }


        if (!Auth::attempt($data)) {
            RateLimiter::hit($throttlekey);
            // ایمبل و رمز رو در دیتا بیس چک میکنه درست بود در سشن اجازه لاگین میده
            throw ValidationException::withMessages([
                'email' => ['Invalid credential'],
                // قرمز ارور بده که همچین کاربری نداریم
            ]);
        }

        RateLimiter::clear($throttlekey);

        $user = Auth::user();

        if (!$user->status) {
            //  اگر استاتوس کاربر فالس هست لاگ اوتش کن
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => ['your accent id inactive'],
            ]);
        }
        return $user;
    }

    private function apiAuthenticate(array $data, string $throttlekey): User
    {

        if (RateLimiter::tooManyAttempts($throttlekey, 5)) {
            throw ValidationException::withMessages([
                'email' => [__('too many login attempts . please try again in :seconds seconds. ', [
                    'seconds' => RateLimiter::availableIn($throttlekey)
                ])],
            ]);
        }
        $user = User::where('email', $data['email'])->first();

        if (!$user or !Hash::check($data['password'], $user->password)) {
            RateLimiter::hit($throttlekey,600);
            throw ValidationException::withMessages([
                'email' => ['Invalid Credential. '],
            ]);
        }


        return $user;
    }

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
}
