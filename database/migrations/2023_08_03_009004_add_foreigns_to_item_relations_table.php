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
        Schema::table('item_relations', function (Blueprint $table) {
            $table
                ->foreign('item_id')
                ->references('id')
                ->on('items')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('item_relation_type_id')
                ->references('id')
                ->on('item_relation_types')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('item_relations', function (Blueprint $table) {
            $table->dropForeign(['item_id']);
            $table->dropForeign(['item_relation_type_id']);
        });
    }
};
