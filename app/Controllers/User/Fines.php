<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\FinesModel;

class Fines extends BaseController
{
    public function list()
    {
        $fines_model = new FinesModel();
        $user_id = session()->get('user_id');
        
        $fines = $fines_model
            ->where('user_id', $user_id);

        return view('user/fines.php',[
            'fines' => $fines
        ]);
    }
}
