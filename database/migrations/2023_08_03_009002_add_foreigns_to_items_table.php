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
        Schema::table('items', function (Blueprint $table) {
            $table
                ->foreign('vendor_id')
                ->references('id')
                ->on('vendors')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('itemType_id')
                ->references('id')
                ->on('item_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('github_repo_id')
                ->references('id')
                ->on('github_repos')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('npm_package_id')
                ->references('id')
                ->on('npm_packages')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('packagist_package_id')
                ->references('id')
                ->on('packagist_packages')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['itemType_id']);
            $table->dropForeign(['github_repo_id']);
            $table->dropForeign(['npm_package_id']);
            $table->dropForeign(['packagist_package_id']);
        });
    }
};
