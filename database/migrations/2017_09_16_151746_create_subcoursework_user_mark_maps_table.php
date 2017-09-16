<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubcourseworkUserMarkMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subcoursework_user_mark_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('subcoursework_id');
            $table->integer('user_id');
            $table->double('marks');
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
        Schema::dropIfExists('subcoursework_user_mark_maps');
    }
}
