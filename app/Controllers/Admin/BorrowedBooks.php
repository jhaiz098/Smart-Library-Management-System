<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BorrowingModel;
use App\Models\BorrowingHistory;
use App\Models\LibrarySettingsModel;
use App\Models\FinesModel;

class BorrowedBooks extends BaseController
{
    public function borrowed_books_list()
    {
        $borrowing_model = new BorrowingModel();
        $library_settings_model = new LibrarySettingsModel();

        $perPage = 10;

        $borrowed_books = $borrowing_model
            ->select('
                borrowings.*,

                borrower.library_id as borrower_library_id,
                borrower.full_name as borrower_name,

                books.title as book_title,

                issuer.library_id as issued_by_library_id,
                issuer.full_name as issued_by_name,

                CASE 
                    WHEN borrowings.due_date < NOW() THEN "Overdue"
                    ELSE "Borrowed"
                END as status_label
            ')
            ->join('users as borrower', 'borrower.id = borrowings.user_id')
            ->join('books', 'books.id = borrowings.book_id')
            ->join('users as issuer', 'issuer.id = borrowings.issued_by', 'left')
            ->where('borrowings.status', 'borrowed')
            ->orderBy('borrowings.borrow_date', 'DESC')
            ->paginate($perPage);

        $daily_overdue_fine = $library_settings_model->first()['daily_overdue_fine'];
        
        return view('admin/borrowed_books/borrowed_books', [
            'borrowed_books' => $borrowed_books,
            'pager' => $borrowing_model->pager,
            'borrow_status' => 'borrowed',
            'daily_overdue_fine' => $daily_overdue_fine
        ]);
    }

    public function returned_books_list()
    {
        $borrowing_model = new BorrowingModel();

        $perPage = 10;

        $returned_books = $borrowing_model
            ->select('
                borrowings.*,

                borrower.library_id as borrower_library_id,
                borrower.full_name as borrower_name,

                books.title as book_title,

                issuer.library_id as issued_by_library_id,
                issuer.full_name as issued_by_name
            ')
            ->join('users as borrower', 'borrower.id = borrowings.user_id')
            ->join('books', 'books.id = borrowings.book_id')
            ->join('users as issuer', 'issuer.id = borrowings.issued_by', 'left')
            ->where('borrowings.status', 'returned')
            ->orderBy('borrowings.borrow_date', 'DESC')
            ->paginate($perPage);

        return view('admin/borrowed_books/returned_books', [
            'returned_books' => $returned_books,
            'pager' => $borrowing_model->pager,
            'borrow_status' => 'returned',
        ]);
    }

    public function borrowed_books_return()
    {
        $borrowing_model = new BorrowingModel();
        $history_model = new BorrowingHistory();
        $library_settings_model = new LibrarySettingsModel();
        $fine_model = new FinesModel();

        $id = $this->request->getPost('borrowing_id');

        $role_id = (int) session()->get('role_id');

        // ROLE CHECK
        if (!in_array($role_id, [1, 2])) {
            return redirect()->back()
                ->with('error', 'You are not authorized to process returns.');
        }

        $borrowing = $borrowing_model->find($id);

        // check if borrowing exists
        if (!$borrowing) {
            return redirect()->back()
                ->with('error', 'Borrowing record not found.');
        }

        // only borrowed can be returned
        if ($borrowing['status'] !== 'borrowed') {
            return redirect()->back()
                ->with('error', 'This borrowing cannot be returned.');
        }

        $now = date('Y-m-d H:i:s');

        // update borrowing
        $borrowing_model->update($id, [
            'status' => 'returned',

            'return_date' => $now,

            'returned_to' => session()->get('user_id'),

            'remarks' => $this->request->getPost('remarks')
                ?: 'Book returned successfully.'
        ]);

        // history log
        $history_model->insert([
            'borrowing_id' => $id,

            'action' => 'returned',

            'performed_at' => $now,
            'performed_by' => session()->get('user_id'),

            'remarks' => $this->request->getPost('remarks')
                ?: 'Book returned successfully.'
        ]);

        /*
        |--------------------------------------------------------------------------
        | CREATE FINE IF OVERDUE
        |--------------------------------------------------------------------------
        */

        $due_date = strtotime($borrowing['due_date']);
        $return_date = strtotime($now);

        // overdue check
        if ($return_date > $due_date) {

            // compute overdue days
            $seconds_late = $return_date - $due_date;

            $days_late = ceil($seconds_late / (60 * 60 * 24));

            // example fine formula
            $fine_per_day = $library_settings_model->first()['daily_overdue_fine'];

            $amount = $days_late * $fine_per_day;

            // insert fine
            $fine_model->insert([

                'borrowing_id' => $id,

                'user_id' => $borrowing['user_id'],

                'amount' => $amount,

                'remarks' => "Overdue by {$days_late} day(s).",

                'status' => 'unpaid',

                'issued_by' => session()->get('user_id')
            ]);
        }

        return redirect()->back()
            ->with('success', 'Book returned successfully.');
    }



    public function borrowed_books_extend()
    {
        $borrowing_model = new BorrowingModel();
        $history_model = new BorrowingHistory();

        $id = $this->request->getPost('borrowing_id');
        $role_id = (int) session()->get('role_id');

        // ROLE CHECK
        if (!in_array($role_id, [1, 2])) {
            return redirect()->back()
                ->with('error', 'You are not authorized to extend borrowings.');
        }

        $borrowing = $borrowing_model->find($id);

        // check if borrowing exists
        if (!$borrowing) {
            return redirect()->back()
                ->with('error', 'Borrowing record not found.');
        }

        // only borrowed/overdue can be extended
        if (!in_array($borrowing['status'], ['borrowed', 'overdue'])) {
            return redirect()->back()
                ->with('error', 'This borrowing cannot be extended.');
        }

        $extend_days = (int) $this->request->getPost('extend_days');

        // validate extension
        if ($extend_days <= 0) {
            return redirect()->back()
                ->with('error', 'Invalid extension days.');
        }

        // compute new due date
        $new_due_date = date(
            'Y-m-d H:i:s',
            strtotime($borrowing['due_date'] . " +{$extend_days} days")
        );

        // update borrowing
        $borrowing_model->update($id, [
            'due_date' => $new_due_date,

            'remarks' => $this->request->getPost('remarks')
                ?: "Borrowing extended by {$extend_days} day(s)."
        ]);

        $history_model->insert([
            'borrowing_id' => $id,

            'action' => 'extended',

            'previous_due_date' => $borrowing['due_date'],
            'new_due_date' => $new_due_date,

            'performed_at' => date('Y-m-d H:i:s'),
            'performed_by' => session()->get('user_id'),

            'remarks' => $this->request->getPost('remarks')
                ?: "Borrowing extended by {$extend_days} day(s)."
        ]);
        
        return redirect()->back()
            ->with('success', "Borrowing extended by {$extend_days} day(s).");
    }

    public function borrowed_books_history($id)
    {
        $borrowing_history_model = new BorrowingHistory();
        
        // $histories = $borrowing_history_model
        // ->where('borrowing_id', $id)
        // ->findAll();

        $histories = $borrowing_history_model
            ->select('
                borrowing_history.*,
                performer.library_id as performer_library_id,
                performer.full_name as performer_full_name
            ')
            ->join('users as performer', 'performer.id = borrowing_history.performed_by')
            ->where('borrowing_id', $id)
            ->findAll();

        return view('partials/admin/borrowing_history_content', [
            'histories' => $histories
        ]);
    }
}
