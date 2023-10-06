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
        Schema::create('repositories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->string('license');
            $table->longText('readme');
            $table->json('data');
            $table->json('composer');
            $table->json('npm');
            $table->json('code_analyzer');
            $table->unsignedBigInteger('repository_type_id');
            $table->unsignedBigInteger('organization_id');
            $table->unsignedBigInteger('owner_id');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repositories');
    }
};
