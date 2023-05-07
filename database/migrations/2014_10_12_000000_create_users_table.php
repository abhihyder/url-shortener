<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->id();
            $table->string('name')->nullable();
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->bigInteger('role_id')->default(3);
            $table->bigInteger('referrer_id')->nullable();
            $table->tinyInteger('is_dark')->default(0);
            $table->tinyInteger("status")->default(1);
            $table->boolean('earning_disable')->default(false);
            $table->string("login_ip", 32)->nullable();
            $table->string("register_ip", 32)->nullable();
            $table->boolean('mail_notify')->default(true);
            $table->string('file_name')->nullable();
            $table->string('file_path')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
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
