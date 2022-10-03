<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id')->comment("Id of users table");
            /*$table->foreign('user_id')->references('id')->on('users');*/
            /*$table->integer("school_id")->comment("Id of school table");*/
            $table->integer('student_id')->comment("Id of students table");
            $table->integer('grade_id')->comment("Id of grades table");
            /*$table->foreign('student_id')->references('id')->on('students');*/
            /*$table->integer("student_id")->comment("Id of students table");*/
            $table->enum("gender", ['M', 'F'])->comment("M=>Male, F=>Female");
            $table->integer('behaviour_id')->comment("Id of behaviour table");
            /*$table->foreign('behaviour_id')->references('id')->on('behaviors');*/

            /*$table->integer("behaviour_id")->comment("Id of behaviour table");*/
            /*$table->integer("location_id")->comment("Id of locations table");*/
            $table->integer('location_id')->comment("Id of locations table");
           /* $table->foreign('location_id')->references('id')->on('locations');*/

            /*$table->integer("intervention_id")->comment("Id of intervention table");*/
            $table->integer('intervention_id')->comment("Id of interventions table");
           /* $table->foreign('intervention_id')->references('id')->on('interventions');*/
            $table->date("date");
            $table->time("time");
            $table->integer("self_awareness")->comment("0=>Poor, 1->Avg 2=>optimal");
            $table->integer("self_management")->comment("0=>Poor, 1->Avg 2=>optimal");
            $table->integer("responsible_decision_making")->comment("0=>Poor, 1->Avg 2=>optimal");
            $table->integer("relationship_skills")->comment("0=>Poor, 1->Avg 2=>optimal");
            $table->integer("social_awareness")->comment("0=>Poor, 1->Avg 2=>optimal");
            $table->longText("other_notes")->comment("Other notes")->nullable();
            $table->string("student")->nullable();
            $table->enum("status",['0','1'])->comment("1=>ACtive, 0=>Archieve");
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
        Schema::dropIfExists('reports');
    }
}
