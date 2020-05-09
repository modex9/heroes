<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BannedController extends Controller
{
    public function bannedMessage(Request $request) {
        return view('banned.message', ['user' => $request->user()]);
    }
}
