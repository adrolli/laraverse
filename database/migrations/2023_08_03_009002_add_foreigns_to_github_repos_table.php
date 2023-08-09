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
        Schema::table('github_repos', function (Blueprint $table) {
            $table
                ->foreign('github_organization_id')
                ->references('id')
                ->on('github_organizations')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('github_owner_id')
                ->references('id')
                ->on('github_owners')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('github_repos', function (Blueprint $table) {
            $table->dropForeign(['github_organization_id']);
            $table->dropForeign(['github_owner_id']);
        });
    }
};
