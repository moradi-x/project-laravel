<?php

namespace Database\Factories;

use App\Enums\CommentStatusEnum;
use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;


class CommentFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName().''.$this->faker->lastName(),
            'email' =>$this->faker->email(),
            'status' => $this->faker->randomElement(CommentStatusEnum::values()) ,
            'comment' => $this->faker->text(),
            'post_id' => Post::inRandomOrder()->first()->id 
        ];
    }
}
