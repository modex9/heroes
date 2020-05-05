<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Faction;
use App\Hero;
use Illuminate\Http\Request;

class HeroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $heroes = Hero::all();
        return view('hero.index', compact( 'heroes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $factions = Faction::all();
        return view('hero.create', compact('factions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Hero::create([
           'name' => $request->name,
           'description' => $request->description,
           'picture' => $request->picture,
           'faction_id' => $request->faction,
        ]);
        return redirect('hero');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function show(Hero $hero)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function edit(Hero $hero)
    {
        $factions = Faction::all();
        return view('hero.edit', compact('hero', 'factions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Hero $hero)
    {
        $hero->name = $request->name;
        $hero->picture = $request->picture;
        $hero->description = $request->description;
        $hero->faction_id = $request->faction;
        $hero->save();
        return redirect('hero');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Hero  $hero
     * @return \Illuminate\Http\Response
     */
    public function destroy(Hero $hero)
    {
        $hero->delete();
        return redirect('hero');
    }
}
