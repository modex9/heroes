<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Admin\AbstractAdminController;

class AdminController extends AbstractAdminController
{
    public function index() {
        return view('admin.index');
    }
}
