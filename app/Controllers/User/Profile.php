<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    public function display()
    {
        $userId = session()->get('user_id');

        $userModel = new \App\Models\UserModel();
        $borrowingModel = new \App\Models\BorrowingModel();
        $reservationModel = new \App\Models\ReservationModel();
        $fineModel = new \App\Models\FinesModel();

        $user = $userModel->find($userId);

        $totalBorrowed = $borrowingModel
            ->where('user_id', $userId)
            ->countAllResults();

        $activeBorrowings = $borrowingModel
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->countAllResults();

        $pendingReservations = $reservationModel
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->countAllResults();

        $unpaidFines = $fineModel
            ->selectSum('amount')
            ->where('user_id', $userId)
            ->where('status', 'unpaid')
            ->first();

        return view('user/profile', [
            'user' => $user,
            'totalBorrowed' => $totalBorrowed,
            'activeBorrowings' => $activeBorrowings,
            'pendingReservations' => $pendingReservations,
            'unpaidFines' => $unpaidFines['amount'] ?? 0,
        ]);
    }
}
