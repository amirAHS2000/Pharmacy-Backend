<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePrescsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prescs', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('doctor');
            $table->integer('total_price')->nullable();
            $table->boolean('paid')->default(false);
            $table->boolean('delivered')->default(false);
            $table->integer('patient_id');
            $table->timestamps();

            $table->foreign('patient_id')->references('id')->on('patients')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prescs');
    }
}
