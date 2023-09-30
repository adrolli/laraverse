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
        Schema::create('github_searches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('keyphrase');
            $table->integer('count');
            $table->integer('pages');
            $table->integer('nextpage');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('github_searches');
    }
};
