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
        Schema::create('github_repo_github_tag', function (Blueprint $table) {
            $table->unsignedBigInteger('github_repo_id');
            $table->unsignedBigInteger('github_tag_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_repo_github_tag');
    }
};
