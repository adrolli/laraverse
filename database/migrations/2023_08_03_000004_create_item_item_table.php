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
            $table->boolean('composer_require')->nullable();
            $table->boolean('composer_require_dev')->nullable();
            $table->boolean('composer_conflict')->nullable();
            $table->boolean('composer_replace')->nullable();
            $table->boolean('composer_provide')->nullable();
            $table->boolean('composer_suggest')->nullable();
            $table->boolean('npm_dependency')->nullable();
            $table->boolean('npm_dev_dependendy')->nullable();
            $table->boolean('npm_peer_dependency')->nullable();
            $table->boolean('other_dependency');
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
