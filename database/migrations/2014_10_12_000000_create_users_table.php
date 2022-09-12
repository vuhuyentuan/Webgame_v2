<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 255);
            $table->integer('role')->default(0);
            $table->string('email', 255)->nullable();
            $table->string('password', 255);
            $table->string('phone', 255)->nullable();
            $table->integer('point')->default(0);
            $table->string('facebook_link', 255)->nullable();
            $table->string('provider', 255)->nullable();
            $table->string('provider_id', 255)->nullable();
            $table->integer('vip')->default(0);
            $table->string('avatar', 255)->nullable();
            $table->string('avatar_orginal', 255)->nullable();
            $table->string('banned_status', 255)->default('unbanned');
            $table->string('recovery_token', 255)->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert([
            [
                'name' => 'Admin',
                'username' => 'admin',
                'email' => 'admin@webgame.com',
                'password' => Hash::make('admin@123456'),
                'role' => 1
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
