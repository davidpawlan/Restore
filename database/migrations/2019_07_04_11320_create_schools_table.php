<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment("User's Table Id");
           /* $table->foreign('user_id')->references('id')->on('users');*/
            $table->string('principle_name')->comment("Princile name for school")->nullable();
            $table->string('plain_password')->comment("Plain password etxt to show in admin");
            $table->string('profile_image')->nullable();
        });

        /*Schema::table('schools', function($table) {
             $table->foreign('user_id')->references('id')->on('users');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schools');
    }
}
