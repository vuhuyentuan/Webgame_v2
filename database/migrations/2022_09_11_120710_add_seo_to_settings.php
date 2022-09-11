<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSeoToSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->text('contacts')->nullable()->after('maintenance');
            $table->text('javascript')->nullable()->after('maintenance');
            $table->string('secondary_color')->default('#343a40')->after('maintenance');
            $table->string('main_color')->default('#343a40')->after('maintenance');
            $table->string('keywords')->nullable()->after('maintenance');
            $table->string('seo_description')->nullable()->after('maintenance');
            $table->string('seo_title')->nullable()->after('maintenance');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            //
        });
    }
}
