<?php

namespace App\Http\Controllers;

use App\Faction;
use Illuminate\Http\Request;

class FactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('faction.index', ['factions' => Faction::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('faction.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Faction::create([
            'name' => $request->name,
            'picture' => $request->picture,
            'description' => $request->description
        ]);
        return redirect('faction');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function show(Faction $faction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function edit(Faction $faction)
    {
        return view('faction.edit', ['faction' => $faction]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Faction $faction)
    {
        $faction->name = $request->name;
        $faction->picture = $request->picture;
        $faction->description = $request->description;
        $faction->save();
        return redirect('faction');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Faction  $faction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Faction $faction)
    {
        $faction->delete();
        return redirect('faction');
    }
}
