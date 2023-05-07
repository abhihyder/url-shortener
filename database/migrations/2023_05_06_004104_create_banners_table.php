<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('name', 64)->nullable();
            $table->bigInteger('user_id');
            $table->string('file_name', 64);
            $table->string('file_path');
            $table->string('disk_type', 20)->nullable();
            $table->string('disk_prefix', 64)->nullable();
            $table->string('width', 20)->nullable();
            $table->string('height', 20)->nullable();
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
        Schema::dropIfExists('banners');
    }
}
