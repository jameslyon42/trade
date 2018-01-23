<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('positions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('security_id')->unsigned();
            $table->integer('portfolio_id')->unsigned();
            $table->integer('shares');
            $table->decimal('entry_price', 8, 2);
            $table->dateTime('entry_timestamp');
            $table->decimal('exit_price', 8, 2)->nullable();
            $table->dateTime('exit_timestamp')->nullable();

            $table->foreign('security_id')->references('id')->on('securities');
            $table->foreign('portfolio_id')->references('id')->on('portfolios');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('positions');
    }
}
