<?php 

namespace App\Actions\Panel\User;

use App\Models\User;

class UpdateUserAction{

    public function handle(array $data, User $user){

        
        $data['status'] = $data['status'] === 'active' ? 1 : 0;
        $user->update($data);
        $user->refresh();

        return [
            "user" => $user
        ];
    }
}