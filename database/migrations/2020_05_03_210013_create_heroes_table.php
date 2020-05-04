<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHeroesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heroes', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('description')->nullable();
            $table->string('picture')->nullable();
            $table->integer('faction_id')->default(1);
            $table->integer('stats_id')->default(1);
        });

        DB::table('heroes')->insert(array(
            'name' => 'Agrael',
            'description' => 'Demon lord',
            'picture' => 'https://vignette.wikia.nocookie.net/mightandmagic/images/5/53/Agrael.jpg/revision/latest?cb=20150210204422&path-prefix=en',
        ));
        DB::table('heroes')->insert(array(
            'name' => 'Nebiros',
            'description' => 'Demon servant',
            'picture' => 'https://vignette.wikia.nocookie.net/mightandmagic/images/c/cf/Veyer.jpg/revision/latest/top-crop/width/360/height/360?cb=20121211213543&path-prefix=en',
        ));
        DB::table('heroes')->insert(array(
            'name' => 'Nicolai',
            'description' => 'Demon lord',
            'picture' => 'https://vignette.wikia.nocookie.net/mightandmagic/images/8/83/HeroNicolaiVampireV.png/revision/latest?cb=20150224183646&path-prefix=en',
            'faction_id' => 2
        ));
        DB::table('heroes')->insert(array(
            'name' => 'Xardas',
            'description' => 'The necromancer',
            'picture' => 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTHzzleFOUm_BsqtTI8WggFft79ZhROlhSHHRryCZaiWAEcrTaNLg&s',
            'faction_id' => 2
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('heroes');
    }
}
