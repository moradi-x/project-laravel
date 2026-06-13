<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class PostFactory extends Factory
{

    public function definition(): array
    {

        $title = $this->faker->unique()->sentence ;
        $uploadImage = UploadedFile::fake()->image(public_path('images/test.jpg'),640,480);
        $thumbnail = $uploadImage->store();

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'status' => $this->faker->boolean(),
            'content' => $this->faker->text(1000),
            'user_id' => User::inRandomOrder()->first()->id,
            'thumbnail' =>  "storage/$thumbnail" ,
        ];
    }
}
