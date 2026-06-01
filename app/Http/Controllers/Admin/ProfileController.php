<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class ProfileController extends AdminController
{
    public function index()
    {
        return view('admin.user.profile');
    }


}
