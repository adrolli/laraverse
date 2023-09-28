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
        Schema::table('repositories', function (Blueprint $table) {

            $table->bigInteger('ghid');
            $table->string('homepage')->nullable();
            $table->text('description')->nullable()->change();
            $table->longText('composer')->nullable()->change();
            $table->longText('npm')->nullable()->change();
            $table->longText('readme')->nullable()->change();
            $table->longText('changelog')->nullable()->change();
            $table->longText('licensefile')->nullable()->change();
            $table->dropColumn('package_type');
            $table->json('code_analyzer')->nullable()->change();
            $table->unsignedBigInteger('organization_id')->nullable()->change();
            $table->unsignedBigInteger('owner_id')->nullable()->change();
            $table->boolean('private');
            $table->boolean('public');
            $table->boolean('archived');
            $table->boolean('disabled');
            $table->boolean('fork');
            $table->boolean('template');
            $table->boolean('vite');
            $table->boolean('tailwind');
            $table->boolean('docker');
            $table->boolean('database');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repositories', function (Blueprint $table) {
            $table->dropColumn('ghid');
            $table->dropColumn('homepage');
            $table->dropColumn('changelog');
            $table->dropColumn('licensefile');
            $table->string('package_type');
            $table->json('code_analyzer')->nullable(false)->change();
            $table->longText('composer')->nullable(false)->change();
            $table->longText('npm')->nullable(false)->change();
            $table->longText('readme')->nullable(false)->change();
            $table->longText('changelog')->nullable(false)->change();
            $table->longText('licensefile')->nullable(false)->change();
            $table->unsignedBigInteger('organization_id')->nullable(false)->change();
            $table->unsignedBigInteger('owner_id')->nullable(false)->change();
            $table->dropColumn('private');
            $table->dropColumn('public');
            $table->dropColumn('archived');
            $table->dropColumn('disabled');
            $table->dropColumn('fork');
            $table->dropColumn('template');
            $table->dropColumn('vite');
            $table->dropColumn('tailwind');
            $table->dropColumn('docker');
            $table->dropColumn('database');
        });
    }
};