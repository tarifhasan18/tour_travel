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
        Schema::table('site_settings', function (Blueprint $table) {
            $table->string('ui_footer_note')->after('footer_ui_name')->nullable();
            $table->string('contact_google_map')->after('ui_footer_note')->nullable();
            $table->string('contact_open_close')->after('contact_google_map')->nullable();
            $table->string('slider_keyword1')->after('contact_open_close')->nullable();
            $table->string('slider_image1')->after('slider_keyword1')->nullable();
            $table->string('slider_keyword2')->after('slider_image1')->nullable();
            $table->string('slider_image2')->after('slider_keyword2')->nullable();
            $table->string('slider_keyword3')->after('slider_image2')->nullable();
            $table->string('slider_image3')->after('slider_keyword3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn(['ui_footer_note','contact_google_map','contact_open_close','slider_keyword1','slider_image1','slider_keyword2','slider_image2','slider_keyword3','slider_image3']);
        });
    }
};
