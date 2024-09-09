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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('email')->default('info@example.com');
            $table->string('phone')->default('+012 345 6789');
            $table->string('address')->default('123 Street, New York, USA');
            $table->string('facebook')->default('#');
            $table->string('twitter')->default('#');
            $table->string('linkedin')->default('#');
            $table->string('youtube')->default('#');
            $table->string('instagram')->default('#');
            $table->string('copyright')->default('#');
            $table->string('copyright_links')->default('#');
            $table->string('ui_logo')->default('image');
            $table->string('ui_site_name')->default('Eastern Tours');
            $table->string('admin_logo')->default('logo');
            $table->string('admin_site_name')->default('eastern tours');
            $table->string('footer_ui_name')->default('Eastern Tours');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
