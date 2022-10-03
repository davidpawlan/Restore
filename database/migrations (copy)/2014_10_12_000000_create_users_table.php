<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
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
            /*$table->string('principle_name')->comment("Princile name for school")->nullable();*/
            $table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            /*$table->string('plain_password')->comment("Plain password etxt to show in admin");*/
           /* $table->string('profile_image');*/
            $table->enum("type",['A','S'])->comment("A=>Admin, S=>School");
            $table->enum("status",['0','1'])->comment("1=>Active, 0=>Deactivate");
            /*$table->rememberToken();*/
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
