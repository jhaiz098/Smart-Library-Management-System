<?php

namespace App\Controllers;

use App\Models\BorrowingModel;
use App\Models\BookModel;
use App\Models\ReservationModel;
use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        $books_model = new BookModel();
        $users_model = new UserModel();
        $borrowed_books_model = new BorrowingModel();
        $reservations_model = new ReservationModel();

        $data['total_books'] = $books_model
            ->countAllResults();

        $data['total_members'] = $users_model
            ->countAllResults();

        $data['total_borrowed'] = $borrowed_books_model
            ->countAllResults();

        $data['total_reservations'] = $reservations_model
            ->countAllResults();

        return view('home', $data);
    }
}
