<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Ban;
use App\Unban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Controllers\Admin\AbstractAdminController;

class BanController extends AbstractAdminController
{
    public function execute(Request $request) {
        $fields = $request->all();
        $fields['issuer'] = $request->user()->id;

        $not_validated = $this->validateData($request, Ban::getRules());
        if($not_validated)
            return $not_validated;

        $ban = Ban::firstOrCreate($fields);
        if($ban->wasRecentlyCreated)
            $data['success'] = true;
        else $data['success'] = false;
        return response()->json($data);
    }

    public function amend(Request $request) {
        $fields = $request->all();
        $fields['issuer'] = $request->user()->id;

        $not_validated = $this->validateData($request, Unban::getRules());
        if($not_validated)
            return $not_validated;

        $fields['ban_id'] = User::find($fields['user_id'])->bans->last()->id;
        unset($fields['user_id']);
        $unban = Unban::firstOrCreate($fields);
        if($unban->wasRecentlyCreated)
            $data['success'] = true;
        else $data['success'] = false;
        return response()->json($data);
    }
}
