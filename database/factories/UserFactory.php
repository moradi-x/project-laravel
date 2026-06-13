<?php

namespace Database\Factories;

use App\Enums\UserRoleEnum;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class UserFactory extends Factory
{


    public function definition(): array
    {
        return [
            'name' => $this->faker->name ,
            'family' => $this->faker->lastName(),
            'email' => $this->faker->unique()->safeEmail(),
            'status'=> $this->faker->boolean(),
            'password' => 'password',
            'remember_token' => Str::random(10),
            'role' => $this->faker->randomElement(UserRoleEnum::values())
        ];
    }

}
