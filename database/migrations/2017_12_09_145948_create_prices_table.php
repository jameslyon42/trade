<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('security_id')->unsigned();
            $table->string('interval');
            $table->decimal('open', 8, 4);
            $table->decimal('high', 8, 4);
            $table->decimal('close', 8, 4);
            $table->integer('volume');
            $table->datetime('timestamp');

            $table->unique([
                'security_id', 
                'interval', 
                'timestamp'
            ]);
            $table->foreign('security_id')->references('id')->on('securities');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
