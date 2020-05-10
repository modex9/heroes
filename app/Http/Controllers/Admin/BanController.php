<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use App\Ban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class BanController extends Controller
{
    public function execute(Request $request) {
        $fields = $request->all();
        $fields['issuer'] = $request->user()->id;
        $ban = Ban::firstOrCreate($fields);
        if($ban->wasRecentlyCreated)
            $data['success'] = true;
        else $data['success'] = false;
        return response()->json($data);
    }
}
