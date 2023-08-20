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
            $table->string('latest_version')->nullable();
            $table->json('versions')->nullable();
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('itemType_id');
            $table->string('website')->nullable();
            $table->integer('popularity');
            $table->integer('rating')->nullable();
            $table->json('rating_data')->nullable();
            $table->integer('health')->nullable();
            $table->json('health_data')->nullable();
            $table->string('github_url')->nullable();
            $table->integer('github_stars')->nullable();
            $table->string('packagist_url')->nullable();
            $table->string('packagist_name')->nullable();
            $table->string('packagist_description')->nullable();
            $table->integer('packagist_downloads')->nullable();
            $table->integer('packagist_favers')->nullable();
            $table->string('npm_url')->nullable();
            $table->integer('github_maintainers')->nullable();
            $table->unsignedBigInteger('github_repo_id')->nullable();
            $table->unsignedBigInteger('npm_package_id')->nullable();
            $table->unsignedBigInteger('packagist_package_id')->nullable();

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
