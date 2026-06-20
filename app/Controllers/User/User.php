<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class User extends BaseController
{
    public function dashboard()
    {
        return view('user/dashboard');
    }
}
