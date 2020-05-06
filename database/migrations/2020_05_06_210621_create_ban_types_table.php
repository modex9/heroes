<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBanTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ban_types', function (Blueprint $table) {
            $table->id();
            $table->string('name', 10);
        });

        DB::table('ban_types')->insert(array(
            ['name' => 'soft'],
            ['name' => 'hard']
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ban_types');
    }
}
