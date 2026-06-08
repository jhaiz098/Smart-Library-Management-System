<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BorrowingModel;
use App\Models\FinesModel;
use App\Models\ReservationModel;

class User extends BaseController
{
    public function dashboard()
    {
        $userId = session()->get('user_id');

        $borrowingModel = new BorrowingModel();
        $fineModel = new FinesModel();
        $reservationModel = new ReservationModel();

        $data['currentBorrowings'] = $borrowingModel
            ->select('borrowings.*, books.title, books.description')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('borrowings.user_id', $userId)
            ->whereIn('borrowings.status', ['borrowed', 'overdue'])
            ->orderBy('borrowings.due_date', 'ASC')
            ->findAll();

        $data['totalBorrowings'] = $borrowingModel
            ->where('user_id', $userId)
            ->countAllResults();

        $data['activeBorrowings'] = $borrowingModel
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->countAllResults();

        $data['overdueBooks'] = $borrowingModel
            ->where('user_id', $userId)
            ->where('status', 'borrowed')
            ->where('due_date <', date('Y-m-d'))
            ->countAllResults();

        $data['reservedBooks'] = $reservationModel
            ->where('user_id', $userId)
            ->where('status', 'pending')
            ->countAllResults();

        $fine = $fineModel
            ->selectSum('amount')
            ->where('user_id', $userId)
            ->where('status', 'unpaid')
            ->first();

        $data['unpaidFines'] = $fine['amount'] ?? 0;

        return view('user/dashboard', $data);
    }
}
