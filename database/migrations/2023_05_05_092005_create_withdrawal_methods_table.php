<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_methods', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('payment_method_id')->index();
            $table->text('withdrawal_account');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->text('address_1');
            $table->text('address_2')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->integer('country_id');
            $table->string('phone', 32)->nullable();
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
        Schema::dropIfExists('withdrawal_methods');
    }
}
