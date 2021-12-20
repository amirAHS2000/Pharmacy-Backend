<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePharmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pharms', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('guide');
            $table->string('usage');
            $table->string('keeping');
            $table->boolean('need_dr');
            $table->string('cat_id');
            $table->timestamps();

            $table->foreign('cat_id')->references('id')->on('categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pharms');
    }
}
