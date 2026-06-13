<?php

namespace App\Http\Controllers;

use App\Enums\UserRoleEnum;
use App\Mail\SendPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {

        $users = User::orderBy('created_at', 'DESC')
            ->where(function ($query) use ($request) {
                return $query->where('name', 'LIKE', "%{$request->search}%")
                    ->orWhere('family', 'LIKE', "%{$request->search}%")
                    ->orWhere('email', 'LIKE', "%{$request->search}%");
            })
            ->withCount('posts')
            ->paginate(10);

        return View::make('admins.user.index', [

            'users' => $users
        ]);
    }

    public function create()
    {
        return View::make('admins.user.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'family' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'status' => ['required', 'in:active,inactive'],
            'role' => ['required', Rule::enum(UserRoleEnum::class)]
        ]);

        $data['password'] = $this->generateRandomPassword(8);
        $data['status'] = $data['status'] === 'active' ? 1 : 0;

        $user = User::create($data);
        // Log::alert("Your Password is `{$data['password']}` ");

        Mail::to($user->email)
            ->queue(new SendPasswordMail($user->FullName, $data['password']));

        return redirect()
            ->route('user.index')
            ->with('message', "user `{$user->FullName}` has been Created");
    }

    public function destroy(User $user)
    {
        $user = $user->loadCount('posts');
        if (!$user->posts_count) {
            $user->delete();
            return redirect()->back()->with('message', "user `{$user->FullName}` has been deleted");
        }
        return redirect()->back()->with('message', "user `{$user->FullName}` has many posts. and are you not allowad to delete ");
    }

    public function edit(User $user)
    {
        return View::make('admins.user.edit', [
            'user' => $user
        ]);
    }

    public function update(User $user, Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'min:3', 'max:100'],
            'family' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:100', 'unique:users,email'],
            'status' => ['required', 'in:active,inactive'],
            'role' => ['required', Rule::enum(UserRoleEnum::class)]
        ]);

        $data['status'] = $data['status'] === 'active' ? 1 : 0;
        $user->update($data);



        return redirect()
            ->route('user.index')
            ->with('message', "user `{$user->FullName}` has been Update");
    }

    public function change(User $user)
    {
        $user->status = !$user->status;
        $user->save();

        return redirect()
            ->back()
            ->with('message', "User {$user->FullName} has been changed. ");
    }

    public function reset(User $user)
    {
        $password = $this->generateRandomPassword(8);
        $user->password = $password;

        Mail::to($user->email)
            ->queue(new SendPasswordMail($user->FullName, $password));

        return redirect()->back()->with('message', "user {$user->FullName} has been reset");
    }

    private function generateRandomPassword($length = 12)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_';
        $charactersLength = strlen($characters);
        $password = '';

        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $password;
    }
}
