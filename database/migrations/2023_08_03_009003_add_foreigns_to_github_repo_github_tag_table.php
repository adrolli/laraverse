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
        Schema::table('github_repo_github_tag', function (Blueprint $table) {
            $table
                ->foreign('github_repo_id')
                ->references('id')
                ->on('github_repos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('github_tag_id')
                ->references('id')
                ->on('github_tags')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('github_repo_github_tag', function (Blueprint $table) {
            $table->dropForeign(['github_repo_id']);
            $table->dropForeign(['github_tag_id']);
        });
    }
};
