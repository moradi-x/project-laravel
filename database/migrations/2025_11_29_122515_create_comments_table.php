<?php

use App\Enums\CommentStatusEnum;
use App\Models\Post;
use ArchTech\Enums\Values;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("email");
            $table->text("comment");
            $table->enum("status" , CommentStatusEnum::values()) ;
            $table->foreignIdFor( Post::class)->constrained();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};

