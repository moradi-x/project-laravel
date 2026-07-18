<?php 

namespace App\Actions\Auth;

use App\Jobs\ResizeAvatarJob;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UpdateProfileAction{

    public function handle(array $data){

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

        return [
            "user" => $user
        ];
    }
}

