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
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('type_id');
            $table->string('website');
            $table->string('rating');
            $table->string('health');
            $table->string('github_url');
            $table->integer('github_stars');
            $table->integer('github_forks');
            $table->json('github_json');
            $table->string('packagist_url');
            $table->string('packagist_name');
            $table->string('packagist_description');
            $table->integer('packagist_downloads');
            $table->integer('packagist_favers');
            $table->string('npm_url');
            $table->integer('github_maintainers');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
