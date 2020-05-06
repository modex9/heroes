<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
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
            $table->id();
            $table->string('nickname', 15)->unique();
            $table->string('email', 60)->unique();
            $table->string('password', 70);
            $table->string('referrer')->nullable();
            $table->string('referralID', 50)->nullable();
            $table->tinyInteger('hero_id')->nullable();
            //todo: sugalvot geresni buda, kad nereiketu ihardcodint
            $table->tinyInteger('role_id')->default(3);
            $table->rememberToken();
            $table->timestamps();
        });

        DB::table('users')->insert(array(
            'nickname' => 'Dynami',
            'email' => 'dynami@gmail.com',
            'password' => Hash::make('dynami'),
            'role_id' => 1
        ));
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
