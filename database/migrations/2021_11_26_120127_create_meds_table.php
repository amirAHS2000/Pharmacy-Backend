<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('meds', function (Blueprint $table) {
            $table->id('mid');
            $table->bigInteger('pharm_id');
            $table->date('exp_date');
            $table->integer('price');
            $table->string('add_info');
            $table->bigInteger('com_id');
            $table->timestamps();

            $table->foreign('pharm_id')->references('pid')->on('pharms')->onDelete('cascade');
            $table->foreign('com_id')->references('cid')->on('comps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('meds');
    }
}
