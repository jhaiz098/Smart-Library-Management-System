<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BorrowingModel;

class BorrowedBooks extends BaseController
{
    public function borrowed_list()
    {
        $borrowing_model = new BorrowingModel();

        $borrowed_books = $borrowing_model
            ->select('borrowings.*,
                books.title,
                books.description,
                users.full_name as issuer_fullname,
                users.library_id as issuer_library_id,
                
                CASE
                    WHEN borrowings.status = "borrowed"
                        AND borrowings.due_date < NOW()
                    THEN "Overdue"
                    ELSE borrowings.status
                END as status_label
                ')
            ->join('books', 'books.id = borrowings.book_id')
            ->join('users', 'users.id = borrowings.user_id')
            ->where('borrowings.status', 'borrowed')
            ->orderBy('borrowings.created_at', 'DESC')
            ->paginate(10);

        return view('user/borrowed_books/borrowed',[
            'borrow_status' => 'borrowed',
            'pager' => $borrowing_model->pager,
            'borrowed_books' => $borrowed_books
        ]);
    }

    public function returned_list()
    {
        $borrowing_model = new BorrowingModel();

        $borrowed_books = $borrowing_model
            ->select('borrowings.*,
                books.title,
                books.description,
                users.full_name as issuer_fullname,
                users.library_id as issuer_library_id,
                
                CASE
                    WHEN borrowings.status = "borrowed"
                        AND borrowings.due_date < NOW()
                    THEN "Overdue"
                    ELSE borrowings.status
                END as status_label
                ')
            ->join('books', 'books.id = borrowings.book_id')
            ->join('users', 'users.id = borrowings.user_id')
            ->where('borrowings.status', 'returned')
            ->orderBy('borrowings.created_at', 'DESC')
            ->paginate(10);

        return view('user/borrowed_books/returned',[
            'borrow_status' => 'returned',
            'pager' => $borrowing_model->pager,
            'borrowed_books' => $borrowed_books
        ]);
    }

    public function all_list()
    {
        $borrowing_model = new BorrowingModel();

        $borrowed_books = $borrowing_model
            ->select('borrowings.*,
                books.title,
                books.description,
                users.full_name as issuer_fullname,
                users.library_id as issuer_library_id,
                
                CASE
                    WHEN borrowings.status = "borrowed"
                        AND borrowings.due_date < NOW()
                    THEN "Overdue"
                    ELSE borrowings.status
                END as status_label
                ')
            ->join('books', 'books.id = borrowings.book_id')
            ->join('users', 'users.id = borrowings.user_id')
            ->orderBy('borrowings.created_at', 'DESC')
            ->paginate(10);

        return view('user/borrowed_books/all',[
            'borrow_status' => 'all',
            'pager' => $borrowing_model->pager,
            'borrowed_books' => $borrowed_books
        ]);
    }
}