<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSectionUserMarkMapsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('section_user_mark_maps', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('section_id');
            $table->integer('user_id');
            $table->double('marks');
            $table->timestamps();
        });

        DB::table('section_user_mark_maps')->insert(
            array(
                'section_id' => 1,
                'user_id' => 1,
                'marks' => 95.0
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
        Schema::dropIfExists('section_user_mark_maps');
    }
}
