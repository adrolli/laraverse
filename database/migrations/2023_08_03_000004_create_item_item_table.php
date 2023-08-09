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
        Schema::create('item_item', function (Blueprint $table) {
            $table->unsignedBigInteger('dep_item_id');
            $table->unsignedBigInteger('item_id');
            $table->boolean('composer_require');
            $table->boolean('composer_require_dev');
            $table->boolean('composer_conflict');
            $table->boolean('composer_replace');
            $table->boolean('composer_provide');
            $table->boolean('composer_suggest');
            $table->boolean('npm_dependency');
            $table->boolean('npm_dev_dependendy');
            $table->boolean('npm_peer_dependency');
            $table->boolean('other_dependency');
            $table->boolean('is_related');
            $table->boolean('is_predecessor');
            $table->boolean('is_successor');
            $table->boolean('is_alternative');
            $table->boolean('is_release');
            $table->boolean('is_version');
            $table->boolean('is_patch');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_item');
    }
};
