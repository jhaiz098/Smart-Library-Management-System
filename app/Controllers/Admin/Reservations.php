<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReservationModel;

class Reservations extends BaseController
{
    public function list()
    {
        return view('admin/reservations');
    }
}