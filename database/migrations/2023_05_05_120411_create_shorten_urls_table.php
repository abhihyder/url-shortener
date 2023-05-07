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
        Schema::create('shorten_urls', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('name')->index();
            $table->string('url');
            $table->string('url_code')->index();
            $table->string('access_code', 30)->nullable();
            $table->string('qr_code_path')->nullable();
            $table->string('expire_date', 30)->nullable();
            $table->integer('total_visit')->default(0);
            $table->integer('unique_visit')->default(0);
            $table->tinyInteger('status')->default(1);
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
        Schema::dropIfExists('shorten_urls');
    }
};
