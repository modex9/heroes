<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('factions', function (Blueprint $table) {
            $table->id();
            $table->string('name', 20);
            $table->string('picture')->nullable();
            $table->string('description')->nullable();
        });

        DB::table('factions')->insert(array(
            'name' => 'Inferno',
            'picture' => 'https://giantbomb1.cbsistatic.com/uploads/original/1/17172/1655652-inferno_by_andemius.jpg',
            'description' => 'Hell-bound heroes.'
        ));
        DB::table('factions')->insert(array(
            'name' => 'Necropolis',
            'picture' => 'https://i.ytimg.com/vi/cpzQG0EiKtM/maxresdefault.jpg',
            'description' => 'Dead heroes'
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('factions');
    }
}
