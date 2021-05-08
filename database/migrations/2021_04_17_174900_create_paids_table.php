<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paids', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->decimal('amount',5,2);
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('bank_name');
            $table->string('branch');
            $table->string('account_no');
            $table->string('account_holder_name');
            $table->string('ifsc');
            $table->string('upi_id');
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
        Schema::dropIfExists('paids');
    }
}
