<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRazorPayKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('razor_pay_keys', function (Blueprint $table) {
            $table->id();
            $table->string('key');
            $table->timestamps();
        });

        // Insert some stuff
        \DB::table('razor_pay_keys')->insert(
            array(
                'key' => 'Enter new value',
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('razor_pay_keys');
    }
}
