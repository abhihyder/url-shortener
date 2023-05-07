<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWithdrawalRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdrawal_requests', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->index();
            $table->integer('withdrawal_method_id');
            $table->string('transection_id')->nullable();
            $table->string('complete_date')->nullable();
            $table->string('note')->nullable();
            $table->double('request_amount', 10, 4)->default(0);
            $table->double('remaining_balance', 10, 4)->default(0);
            $table->integer('updated_by')->nullable();
            $table->integer('status')->default(0)->comment('0=pending, 1=approved, 2=complete, 3=cancelled, 4=returned');
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
        Schema::dropIfExists('withdrawal_requests');
    }
}
