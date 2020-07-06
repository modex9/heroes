<?php

namespace App\Http\Controllers\Admin;

use App\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AbstractAdminController;


class RoleController extends AbstractAdminController
{
    public function getRoles() {
        return json_encode(Role::all());
    }
}
