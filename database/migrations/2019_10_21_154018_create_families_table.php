<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFamiliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('families', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("first")->unsigned();
            $table->unsignedBigInteger("second")->unsigned();
            $table->enum('type' , [
                'son',
                'wife',
                'father'
            ])->default('son');
            $table->foreign("first")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
            $table->foreign("second")->references("id")->on("users")->onUpdate("cascade")->onDelete("cascade");
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
        Schema::dropIfExists('families');
    }
}
