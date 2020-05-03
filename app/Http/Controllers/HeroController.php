<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hero;

class HeroController extends Controller
{
    public function index() {
        return view('hero.create');
    }

    public function store(Request $request) {
        //Todo: validacija herojaus id, ar prisijunges
        Hero::create([
            'name' => $request->hero,
            'description' => $request->description
        ]);
    }
}
