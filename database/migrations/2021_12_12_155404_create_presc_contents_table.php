<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('presc_contents', function (Blueprint $table) {
            $table->id();
            $table->integer('presc_id');
            $table->integer('med_id');
            $table->integer('price');
            $table->boolean('ins_buy');
            $table->timestamps();

            $table->foreign('presc_id')->references('id')->on('prescs')->onDelete('cascade');
            $table->foreign('med_id')->references('id')->on('meds')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('presc_contents');
    }
}
