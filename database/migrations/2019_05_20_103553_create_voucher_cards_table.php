<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_card', function (Blueprint $table) {
            $table->bigIncrements('voucherCardId');
            $table->bigInteger('voucherNumber');
            $table->Integer('balance');
            $table->bigInteger('passengerId')->unsigned();
            $table->foreign("passengerId")->references("passengerId")->on("passenger")->onDelete("cascade");
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
        Schema::dropIfExists('voucher_cards');
    }
}
