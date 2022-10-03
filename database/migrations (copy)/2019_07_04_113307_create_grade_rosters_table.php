<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGradeRostersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('grade_rosters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment("Id of users table");
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('grade_id')->comment("Id of grades table");
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->string("file_name");
            $table->enum("status",['0','1'])->comment("1=>Active, 0=>Inactive");
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
        Schema::dropIfExists('grade_rosters');
    }
}
