<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\FinesModel;

class Fines extends BaseController
{
    public function unpaid_list()
    {
        $fines_model = new FinesModel();

        $user_id = session()->get('user_id');
        $perPage = 10;

        $fines = $fines_model
            ->select('
                fines.*,
                books.title as book_title,
                borrowings.due_date,
                borrowings.return_date
            ')
            ->join('borrowings', 'borrowings.id = fines.borrowing_id')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('fines.user_id', $user_id)
            ->where('fines.status', 'unpaid')
            ->orderBy('fines.created_at', 'DESC')
            ->paginate($perPage);

        foreach ($fines as &$fine) {

            $daysLate = 0;

            if (!empty($fine['due_date']) && !empty($fine['return_date'])) {

                $due = strtotime($fine['due_date']);
                $return = strtotime($fine['return_date']);

                if ($return > $due) {
                    $daysLate = (int) ceil(($return - $due) / 86400);
                }
            }

            $fine['late_by'] = $daysLate . ' day' . ($daysLate != 1 ? 's' : '');
        }

        return view('user/fines/unpaid', [
            'fines' => $fines,
            'pager' => $fines_model->pager,
            'fine_status' => 'unpaid',
        ]);
    }

    public function paid_list()
    {
        $fines_model = new FinesModel();

        $user_id = session()->get('user_id');
        $perPage = 10;

        $fines = $fines_model
            ->select('
                fines.*,
                books.title as book_title,
                borrowings.due_date,
                borrowings.return_date
            ')
            ->join('borrowings', 'borrowings.id = fines.borrowing_id')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('fines.user_id', $user_id)
            ->where('fines.status', 'paid')
            ->orderBy('fines.paid_at', 'DESC')
            ->paginate($perPage);

        foreach ($fines as &$fine) {

            $daysLate = 0;

            if (
                !empty($fine['due_date']) &&
                !empty($fine['return_date'])
            ) {
                $dueDate = strtotime($fine['due_date']);
                $returnDate = strtotime($fine['return_date']);

                if ($returnDate > $dueDate) {
                    $daysLate = (int) ceil(($returnDate - $dueDate) / 86400);
                }
            }

            $fine['late_by'] = "{$daysLate} day" . ($daysLate != 1 ? 's' : '');
        }

        return view('user/fines/paid', [
            'fines' => $fines,
            'pager' => $fines_model->pager,
            'fine_status' => 'paid',
        ]);
    }

    public function all_list()
    {
        $fines_model = new FinesModel();

        $user_id = session()->get('user_id');
        $perPage = 10;

        $fines = $fines_model
            ->select('
                fines.*,
                books.title as book_title,
                borrowings.due_date,
                borrowings.return_date
            ')
            ->join('borrowings', 'borrowings.id = fines.borrowing_id')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('fines.user_id', $user_id)
            ->orderBy('fines.created_at', 'DESC')
            ->paginate($perPage);

        foreach ($fines as &$fine) {

            $daysLate = 0;

            if (
                !empty($fine['due_date']) &&
                !empty($fine['return_date'])
            ) {
                $dueDate = strtotime($fine['due_date']);
                $returnDate = strtotime($fine['return_date']);

                if ($returnDate > $dueDate) {
                    $daysLate = (int) ceil(($returnDate - $dueDate) / 86400);
                }
            }

            $fine['late_by'] = "{$daysLate} day" . ($daysLate != 1 ? 's' : '');
        }

        return view('user/fines/all', [
            'fines' => $fines,
            'pager' => $fines_model->pager,
            'fine_status' => 'all',
        ]);
    }
}
