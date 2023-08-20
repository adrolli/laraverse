<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->text('content')->nullable();
            $table->json('data')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('item_id')->nullable();
            $table->unsignedBigInteger('stack_id')->nullable();
            $table->unsignedBigInteger('post_type_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
