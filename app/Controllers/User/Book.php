<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\BorrowRequestModel;
use App\Models\BorrowRequestHistoryModel;
use App\Models\ReservationModel;
use App\Models\BorrowingModel;

class Book extends BaseController
{
    public function book_list()
    {
        $book_model = new BookModel();
        $category_model = new CategoryModel();

        $data['books'] = $book_model->findAll();

        foreach ($data['books'] as &$book) {
            $category = $category_model->find($book['category_id']);
            $book['category_name'] = $category['name'] ?? '';
        }
        
        return view('user/books', $data);
    }

    public function book_view($id)
    {
        $book_model = new BookModel();
        $category_model = new CategoryModel();
        $borrow_request_model = new BorrowRequestModel();
        $reservation_model = new ReservationModel();
        $borrowing_model = new BorrowingModel();

        $user_id = session()->get('user_id'); // IMPORTANT

        // BOOK
        $book = $book_model->find($id);

        // CATEGORY
        $category = $category_model->find($book['category_id']);
        $book['category_name'] = $category['name'];
        
        // CURRENT BORROWER (global state)
        $current_borrowing = $borrowing_model
            ->where('book_id', $id)
            ->where('status', 'borrowed')
            ->first();

        $book['is_borrowed'] = $current_borrowing ? true : false;

        // USER BORROW REQUEST (important)
        $user_borrow_request = $borrow_request_model
            ->where('book_id', $id)
            ->where('user_id', $user_id)
            ->where('status', 'pending')
            ->first();

        $book['user_borrow_request'] = $user_borrow_request;

        // USER RESERVATION
        $user_reservation = $reservation_model
            ->where('book_id', $id)
            ->where('user_id', $user_id)
            ->where('status', 'pending')
            ->first();

        $book['user_reservation'] = $user_reservation;

        // ALL RESERVATIONS (QUEUE)
        $book['reservations'] = $reservation_model
            ->where('book_id', $id)
            ->where('status', 'pending')
            ->orderBy('created_at', 'ASC')
            ->findAll();

        // ALL BORROW REQUESTS (admin view logic)
        $book['borrow_requests'] = $borrow_request_model
            ->where('book_id', $id)
            ->where('status', 'pending')
            ->findAll();

        // CURRENT BORROWER DETAILS
        $book['borrowings'] = $borrowing_model
            ->where('book_id', $id)
            ->where('status', 'borrowed')
            ->first();

        $buttons = [];

        if (!$book['is_borrowed']) {

            if ($book['user_borrow_request']) {
                $buttons[] = [
                    'text' => 'Cancel Borrow Request',
                    'action' => site_url('user/books/view/cancel_borrow_request/' . $id),
                    'color' => 'danger'
                ];
            } else {
                $buttons[] = [
                    'text' => 'Send Borrow Request',
                    'action' => site_url('user/books/view/send_borrow_request/' . $id),
                    'color' => 'primary'
                ];
            }
        }

        if ($book['is_borrowed']) {

            if ($book['user_reservation']) {
                $buttons[] = [
                    'text' => 'Cancel Reservation',
                    'action' => site_url('user/books/cancel_reservation/' . $id),
                    'color' => 'warning'
                ];
            } else {
                $buttons[] = [
                    'text' => 'Reserve Book',
                    'action' => site_url('user/books/reserve/' . $id),
                    'color' => 'secondary'
                ];
            }
        }

        return view('user/view_book', [
            'book' => $book,
            'buttons' => $buttons
        ]);
    }

    public function send_borrow_request()
    {
        $borrow_request_model = new BorrowRequestModel();

        $user_id = $this->request->getPost('user_id');
        $book_id = $this->request->getPost('book_id');

        // ❗ RULE: user cannot spam requests for same book
        $existing = $borrow_request_model
            ->where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->back()->with('error', 'You already have a pending request for this book.');
        }

        $data = [
            'user_id' => $user_id,
            'book_id' => $book_id,
            'status' => 'pending',
            'request_date' => date('Y-m-d H:i:s'),
        ];

        $borrow_request_model->insert($data);

        return redirect()->to(site_url('user/books/view/' . $book_id))
            ->with('success', 'Borrow request sent.');
    }

    public function cancel_borrow_request()
    {
        $borrow_request_model = new BorrowRequestModel();
        $borrow_requests_history_model = new BorrowRequestHistoryModel();

        $user_id = session()->get('user_id');
        $book_id = $this->request->getPost('book_id');

        // find existing request
        $existing = $borrow_request_model
            ->where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->where('status', 'pending')
            ->first();

        if (!$existing) {
            return redirect()->back()
                ->with('error', "You don't have a pending request for this book.");
        }

        // update request
        $borrow_request_model->update($existing['id'], [
            'status' => 'cancelled',
            'processed_at' => date('Y-m-d H:i:s'),
            'processed_by' => $user_id,
            'remarks' => 'Cancelled by user'
        ]);

        $borrow_requests_history_model->insert([
            'borrow_request_id' => $existing['id'],
            'action' => 'cancelled',
            'performed_at' => date('Y-m-d H:i:s'),
            'performed_by' => $user_id,
            'remarks' => 'Cancelled by user'
        ]);

        return redirect()->back()
            ->with('success', 'Borrow request cancelled successfully.');
    }
}
