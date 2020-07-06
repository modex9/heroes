<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\BanType;
use App\Http\Controllers\Admin\AbstractAdminController;

class BanTypeController extends AbstractAdminController
{
    public function getBanTypesAjax() {
        return json_encode(BanType::all());
    }
}
