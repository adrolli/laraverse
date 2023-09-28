<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('owners', function (Blueprint $table) {

            $table->bigInteger('ghid');
            $table->string('avatar');
            $table->string('gravatar');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

        Schema::table('owners', function (Blueprint $table) {

            $table->dropColumn('ghid');
            $table->dropColumn('avatar');
            $table->dropColumn('gravatar');

        });

    }
};
