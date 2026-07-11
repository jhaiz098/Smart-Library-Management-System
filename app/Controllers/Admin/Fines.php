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

    public function fines_list()
    {
        $fines_model = new FinesModel();

        $perPage = 10;

        $type = $this->request->getGet('type') ?? 'all';

        $query = $fines_model
            ->select('
                fines.*,

                borrower.library_id as borrower_library_id,
                borrower.full_name as borrower_full_name,

                issuer.library_id as issuer_library_id,
                issuer.full_name as issuer_full_name,

                payer.library_id as payer_library_id,
                payer.full_name as payer_full_name,

                books.title as book_title,

                borrowings.borrowing_code,
                borrowings.due_date,
                borrowings.return_date
            ')
            ->join('users as borrower', 'borrower.id = fines.user_id')

            ->join(
                'users as issuer',
                'issuer.id = fines.issued_by',
                'left'
            )

            ->join(
                'users as payer',
                'payer.id = fines.paid_by',
                'left'
            )

            ->join(
                'borrowings',
                'borrowings.id = fines.borrowing_id'
            )

            ->join(
                'books',
                'books.id = borrowings.book_id'
            );

        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        switch ($type) {

            case 'unpaid':
                $query->where('fines.status', 'unpaid');
                break;

            case 'paid':
                $query->where('fines.status', 'paid');
                break;

            case 'all':
            default:
                break;
        }

        $records = $query
            ->orderBy('fines.created_at', 'DESC')
            ->paginate($perPage);

        /*
        |--------------------------------------------------------------------------
        | COMPUTE DAYS LATE
        |--------------------------------------------------------------------------
        */

        foreach ($records as &$fine) {

            $fine['days_late'] = 0;

            if (
                !empty($fine['due_date']) &&
                !empty($fine['return_date'])
            ) {

                $due_date = strtotime($fine['due_date']);
                $return_date = strtotime($fine['return_date']);

                $seconds_late = $return_date - $due_date;

                $days_late = ceil(
                    $seconds_late / (60 * 60 * 24)
                );

                $fine['days_late'] = max(0, $days_late);
            }
        }

        return view('admin/fines', [
            'records' => $records,
            'pager' => $fines_model->pager,
            'fine_status' => $type
        ]);
    }

    public function pay_fine()
    {
        $fines_model = new FinesModel();

        $fine_id = $this->request->getPost('fine_id');
        $remarks = $this->request->getPost('remarks');

        $user_id = session()->get('user_id');
        $role_id = (int) session()->get('role_id');

        // ROLE CHECK
        if (!in_array($role_id, [1, 2])) {
            return redirect()->back()
                ->with('error', 'You are not authorized to process payments.');
        }

        // FIND FINE
        $fine = $fines_model->find($fine_id);

        if (!$fine) {
            return redirect()->back()
                ->with('error', 'Fine record not found.');
        }

        // PREVENT DOUBLE PAYMENT
        if ($fine['status'] === 'paid') {
            return redirect()->back()
                ->with('error', 'This fine is already paid.');
        }

        // UPDATE FINE
        $fines_model->update($fine_id, [
            'status' => 'paid',
            'paid_at' => date('Y-m-d 23:59:59'),
            'paid_by' => $user_id,
            'remarks' => $remarks ?: 'Fine paid successfully.'
        ]);

        return redirect()->to(base_url('admin/unpaid_fines_list'))
            ->with('success', 'Fine payment recorded successfully.');
    }
}
