<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id')->comment("Id of users table");
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('grade_id')->comment("Id of grades table");
            $table->foreign('grade_id')->references('id')->on('grades');
            $table->integer("grade_roster_id")->comment("Id of grade_roster table");
            $table->string("name");
            $table->string("roll_number")->nullable();
            $table->enum('gender', ['M', 'F'])->comment("M=>Male, F=>Female");
            $table->enum('status', ['0', '1'])->comment("0=>Archieve, 1=>Active");
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
        Schema::dropIfExists('students');
    }
}
