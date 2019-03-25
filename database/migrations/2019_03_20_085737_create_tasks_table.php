<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('tid');
            $table->string('taskname');
            $table->integer('completed')->nullable();
            $table->integer('gid')->unsigned();
            $table->timestamps();


            // $table->foreign('gid')->references('gid')->on('goals');
            //Schema::enableForeignKeyConstraints();
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
        Schema::dropIfExists('tasks');
    }
}
