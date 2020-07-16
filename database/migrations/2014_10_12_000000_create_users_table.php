<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->integer("phone")->nullable();
            $table->string("facebook")->nullable();
            $table->enum("state" , [
                '0','1'
            ])->default(1); // 1 active / 0 not active
            $table->integer("age")->unsigned()->nullable();
            $table->integer("weight")->unsigned()->nullable();
            $table->enum("geneder" , [
                "male" , "female"
            ])->default("male");
            $table->time("start_sleep")->nullable();
            $table->time("end_sleep")->nullable();
            $table->enum("heart_audio" , [
                '0','1'
            ])->default(0); // 1 active / 0 not active
            $table->enum("doctor_call" , [
                '0','1'
            ])->default(0); // 1 active / 0 not active
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
