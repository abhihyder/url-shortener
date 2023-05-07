<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('shorten_url_id')->index();
            $table->string('os');
            $table->string('ip', 32)->index();
            $table->string('browser');
            $table->double('payment', 10, 4)->default(0);
            $table->boolean('is_unique')->default(false);
            $table->boolean('earning_disable')->default(false);
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
        Schema::dropIfExists('visitors');
    }
};
