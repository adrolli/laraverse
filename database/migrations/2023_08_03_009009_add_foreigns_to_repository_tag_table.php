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
        Schema::table('repository_tag', function (Blueprint $table) {
            $table
                ->foreign('repository_id')
                ->references('id')
                ->on('repositories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('repo_tag_id')
                ->references('id')
                ->on('repository_tags')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repository_tag', function (Blueprint $table) {
            $table->dropForeign(['repository_id']);
            $table->dropForeign(['repo_tag_id']);
        });
    }
};
