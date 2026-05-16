<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FinesModel;

class Fines extends BaseController
{
    public function paid_fines_list()
    {
        $fines_model = new FinesModel();

        $perPage = 10;

        $paid_fines = $fines_model
            ->select('
                fines.*,

                borrower.library_id as borrower_library_id,
                borrower.full_name as borrower_full_name,

                issuer.library_id as issuer_library_id,
                issuer.full_name as issuer_full_name,

                payer.library_id as payer_library_id,
                payer.full_name as payer_full_name,

                books.title as book_title
            ')
            ->join('users as borrower', 'borrower.id = fines.user_id')
            ->join('users as issuer', 'issuer.id = fines.issued_by')
            ->join('users as payer', 'payer.id = fines.paid_by')
            ->join('borrowings', 'borrowings.id = fines.borrowing_id')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('fines.status', 'paid')
            ->orderBy('fines.paid_at', 'DESC')
            ->paginate($perPage);

        return view('admin/fines/paid_fines_list', [
            'paid_fines' => $paid_fines,
            'pager' => $fines_model->pager,
            'fine_status' => 'paid'
        ]);
    }

    public function unpaid_fines_list()
    {
        $fines_model = new FinesModel();

        $perPage = 10;

        $unpaid_fines = $fines_model
            ->select('
                fines.*,

                borrower.library_id as borrower_library_id,
                borrower.full_name as borrower_full_name,

                issuer.library_id as issuer_library_id,
                issuer.full_name as issuer_full_name,

                payer.library_id as payer_library_id,
                payer.full_name as payer_full_name,

                books.title as book_title
            ')
            ->join('users as borrower', 'borrower.id = fines.user_id')
            ->join('users as issuer', 'issuer.id = fines.issued_by')
            ->join('users as payer', 'payer.id = fines.paid_by')
            ->join('borrowings', 'borrowings.id = fines.borrowing_id')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('fines.status', 'unpaid')
            ->orderBy('fines.paid_at', 'DESC')
            ->paginate($perPage);

        return view('admin/fines/unpaid_fines_list', [
            'unpaid_fines' => $unpaid_fines,
            'pager' => $fines_model->pager,
            'fine_status' => 'unpaid'
        ]);
    }
}
