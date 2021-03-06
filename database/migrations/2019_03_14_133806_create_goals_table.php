<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goals', function (Blueprint $table) {
            $table->increments('gid');
            $table->string('goalname');
            $table->mediumText('goalbody');
            $table->integer('uid')->unsigned();
            $table->string('start');
            $table->string('end');
            $table->timestamps();

            //Schema::enableForeignKeyConstraints();
            // $table->foreign('uid')->references('uid')->on('users')->onDelete('cascade');
            // $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goals');
    }
}
