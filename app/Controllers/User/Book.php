<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\BorrowRequestModel;
use App\Models\BorrowRequestHistoryModel;
use App\Models\ReservationModel;
use App\Models\BorrowingModel;
use App\Models\LibrarySettingsModel;

class Book extends BaseController
{
    public function book_list()
    {
        $book_model = new BookModel();
        $category_model = new CategoryModel();

        $data['books'] = $book_model
            ->where('status', 'active')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $data['pager'] = $book_model->pager;

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
        $library_settings_model = new LibrarySettingsModel();

        $user_id = session()->get('user_id'); // IMPORTANT

        $library_settings = $library_settings_model->first();

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

        $user_borrowing = $borrowing_model
            ->where('book_id', $id)
            ->where('user_id', $user_id)
            ->where('status', 'borrowed')
            ->first();

        $book['user_borrowed'] = $user_borrowing ? true : false;

        // USER BORROW REQUEST (important)
        $user_borrow_request = $borrow_request_model
            ->where('book_id', $id)
            ->where('user_id', $user_id)
            ->orderBy('id', 'DESC')
            ->first();

        $book['user_borrow_request'] = $user_borrow_request;

        $book['has_active_borrow_request'] = (
            $user_borrow_request &&
            in_array($user_borrow_request['status'], [
                'pending',
                'approved',
                'rejected'
            ])
        );

        // USER RESERVATION
        $user_reservation = $reservation_model
            ->where('book_id', $id)
            ->where('user_id', $user_id)
            ->where('status', 'pending')
            ->first();

        $book['user_reservation'] = $user_reservation;

        // ALL RESERVATIONS (QUEUE)
        $book['reservations'] = $reservation_model
            ->select('
                    reservations.*,
                    users.library_id as reserver_library_id,
                    users.full_name as reserver_full_name
                ')
            ->join('users', 'users.id = reservations.user_id')
            ->where('book_id', $id)
            ->where('reservations.status', 'pending')
            ->orderBy('created_at', 'ASC')
            ->findAll();

        // ALL BORROW REQUESTS (admin view logic)
        $book['borrow_requests'] = $borrow_request_model
            ->where('book_id', $id)
            ->where('status', 'pending')
            ->findAll();

        // CURRENT BORROWER DETAILS
        $book['borrowings'] = $borrowing_model
            ->select('
                borrowings.*,
                users.library_id as borrower_library_id,
                users.full_name as borrower_full_name
            ')
            ->join('users', 'users.id = borrowings.user_id')
            ->where('borrowings.book_id', $id)
            ->where('borrowings.status', 'borrowed')
            ->first();

        // FIRST RESERVER
        $first_reserver = null;

        if (!empty($book['reservations'])) {
            $first_reserver = $book['reservations'][0];
        }

        $book['is_first_reserver'] = (
            $first_reserver &&
            $first_reserver['user_id'] == $user_id
        );
        
        
        $buttons = [];

        /*
        |--------------------------------------------------------------------------
        | BOOK IS AVAILABLE
        |--------------------------------------------------------------------------
        */

        $has_valid_borrow_request = (
            $book['user_borrow_request'] &&
            in_array($book['user_borrow_request']['status'], [
                'pending',
                'approved',
                'rejected'
            ])
        );

        if (!$book['is_borrowed']) {

            /*
            |--------------------------------------------------------------------------
            | THERE IS A RESERVATION QUEUE
            |--------------------------------------------------------------------------
            */

            if (!empty($book['reservations'])) {

                /*
                |--------------------------------------------------------------------------
                | USER IS FIRST IN QUEUE
                |--------------------------------------------------------------------------
                */

                if ($book['is_first_reserver']) {

                    // USER ALREADY HAS BORROW REQUEST
                    if ($has_valid_borrow_request) {

                        if ($book['user_borrow_request']['status'] == 'pending') {

                            $buttons[] = [
                                'text' => 'Cancel Borrow Request',
                                'action' => site_url('user/books/view/cancel_borrow_request/' . $id),
                                'color' => 'danger',
                                'type' => 'cancel_borrow_request'
                            ];

                        } elseif ($book['user_borrow_request']['status'] == 'approved') {

                            $buttons[] = [
                                'text' => 'Cancel Approved Request',
                                'action' => site_url('user/books/view/cancel_borrow_request/' . $id),
                                'color' => 'danger',
                                'type' => 'cancel_borrow_request'
                            ];

                        } elseif ($book['user_borrow_request']['status'] == 'rejected') {

                            $buttons[] = [
                                'text' => 'Send Borrow Request Again',
                                'action' => site_url('user/books/view/send_borrow_request/' . $id),
                                'color' => 'primary',
                                'type' => 'borrow_request'
                            ];
                        }

                    } else {

                        $buttons[] = [
                            'text' => 'Send Borrow Request',
                            'action' => site_url('user/books/view/send_borrow_request/' . $id),
                            'color' => 'primary',
                            'type' => 'borrow_request'
                        ];
                    }

                }

                /*
                |--------------------------------------------------------------------------
                | USER IS NOT FIRST IN QUEUE
                |--------------------------------------------------------------------------
                */

                else {

                    /*
                    |--------------------------------------------------------------------------
                    | USER ALREADY RESERVED
                    |--------------------------------------------------------------------------
                    */

                    if ($book['user_reservation']) {

                        $buttons[] = [
                            'text' => 'Cancel Reservation',
                            'action' => site_url('user/books/view/cancel_reserve_book/' . $id),
                            'color' => 'warning',
                            'type' => 'cancel_reservation'
                        ];

                    }

                    /*
                    |--------------------------------------------------------------------------
                    | USER HAS NOT RESERVED YET
                    |--------------------------------------------------------------------------
                    */

                    else {

                        $buttons[] = [
                            'text' => 'Join Reservation Queue',
                            'action' => site_url('user/books/view/reserve_book/' . $id),
                            'color' => 'secondary',
                            'type' => 'reservation'
                        ];
                    }
                }

            }

            /*
            |--------------------------------------------------------------------------
            | NO RESERVATIONS YET
            |--------------------------------------------------------------------------
            */

            else {

                if ($has_valid_borrow_request) {

                    if ($book['user_borrow_request']['status'] == 'pending') {

                        $buttons[] = [
                            'text' => 'Cancel Borrow Request',
                            'action' => site_url('user/books/view/cancel_borrow_request/' . $id),
                            'color' => 'danger',
                            'type' => 'cancel_borrow_request'
                        ];

                    } elseif ($book['user_borrow_request']['status'] == 'approved') {

                        $buttons[] = [
                            'text' => 'Cancel Approved Request',
                            'action' => site_url('user/books/view/cancel_borrow_request/' . $id),
                            'color' => 'danger',
                            'type' => 'cancel_borrow_request'
                        ];

                    } elseif ($book['user_borrow_request']['status'] == 'rejected') {

                        $buttons[] = [
                            'text' => 'Send Borrow Request Again',
                            'action' => site_url('user/books/view/send_borrow_request/' . $id),
                            'color' => 'primary',
                            'type' => 'borrow_request'
                        ];
                    }

                } else {

                    $buttons[] = [
                        'text' => 'Send Borrow Request',
                        'action' => site_url('user/books/view/send_borrow_request/' . $id),
                        'color' => 'primary',
                        'type' => 'borrow_request'
                    ];
                }
            }
        }

        /*
        |--------------------------------------------------------------------------
        | BOOK IS BORROWED
        |--------------------------------------------------------------------------
        */

        if ($book['is_borrowed']) {

            // USER CURRENTLY BORROWED BOOK
            if ($book['user_borrowed']) {

                $buttons[] = [
                    'text' => 'You Currently Borrowed This Book',
                    'action' => '#',
                    'color' => 'dark',
                    'type' => '#'
                ];

            } else {

                // USER ALREADY RESERVED
                if ($book['user_reservation']) {

                    $buttons[] = [
                        'text' => 'Cancel Reservation',
                        'action' => site_url('user/books/view/cancel_reserve_book/' . $id),
                        'color' => 'warning',
                        'type' => 'cancel_reservation'
                    ];

                } else {

                    $buttons[] = [
                        'text' => 'Reserve Book',
                        'action' => site_url('user/books/view/reserve_book/' . $id),
                        'color' => 'secondary',
                        'type' => 'reserve'
                    ];
                }
            }
        }

        return view('user/view_book', [
            'book' => $book,
            'buttons' => $buttons,
            'library_settings' => $library_settings
        ]);
    }

    public function send_borrow_request()
    {
        $borrow_request_model = new BorrowRequestModel();

        $user_id = $this->request->getPost('user_id');
        $book_id = $this->request->getPost('book_id');

        // Prevent duplicate pending requests
        $existing = $borrow_request_model
            ->where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'You already have a pending request for this book.');
        }

        // Insert first
        $borrow_request_model->insert([
            'user_id'      => $user_id,
            'book_id'      => $book_id,
            'status'       => 'pending',
            'request_date' => date('Y-m-d H:i:s'),
        ]);

        // Get generated ID
        $id = $borrow_request_model->getInsertID();

        // Generate code
        $borrow_request_code =
            'REQ-' .
            date('Y') .
            '-' .
            str_pad($id, 6, '0', STR_PAD_LEFT);

        // Update same record
        $borrow_request_model->update($id, [
            'borrow_request_code' => $borrow_request_code
        ]);

        return redirect()
            ->to(site_url('user/books/view/' . $book_id))
            ->with(
                'success',
                "Borrow request sent successfully. Reference No: {$borrow_request_code}"
            );
    }

    public function cancel_borrow_request()
    {
        $borrow_request_model = new BorrowRequestModel();
        $borrow_requests_history_model = new BorrowRequestHistoryModel();
        $reservation_model = new ReservationModel();

        $user_id = session()->get('user_id');
        $book_id = $this->request->getPost('book_id');

        // find existing request
        $existing = $borrow_request_model
            ->where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->whereIn('status', ['pending', 'approved'])
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

        $reservation = $reservation_model
            ->where('user_id', $user_id)
            ->where('book_id', $book_id)
            ->where('status', 'pending')
            ->first();

        if ($reservation) {

            $reservation_model->update($reservation['id'], [
                'status' => 'cancelled'
            ]);
        }

        return redirect()->back()
            ->with('success', 'Borrow request cancelled successfully.');
    }

    public function reserve_book($id)
    {
        $reservation_model = new ReservationModel();
        $borrowing_model = new BorrowingModel();

        $user_id = session()->get('user_id');

        // check if book is currently borrowed
        $is_borrowed = $borrowing_model
            ->where('book_id', $id)
            ->where('status', 'borrowed')
            ->first();

        // OPTIONAL: prevent duplicate reservation
        $existing = $reservation_model
            ->where('book_id', $id)
            ->where('user_id', $user_id)
            ->where('status', 'pending')
            ->first();

        if ($existing) {
            return redirect()->back()
                ->with('error', 'You already reserved this book.');
        }

        // create reservation
        $reservation_model->insert([
            'book_id' => $id,
            'user_id' => $user_id,

            'reservation_date' => date('Y-m-d H:i:s'),

            'status' => 'pending',

            'remarks' => 'Book reserved successfully.',

            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        return redirect()->back()
            ->with('success', 'Book reserved successfully.');
    }

    public function cancel_reserve_book($id)
    {
        $reservation_model = new ReservationModel();

        $user_id = session()->get('user_id');
        $role_id = (int) session()->get('role_id');

        // FIND reservation
        $reservation = $reservation_model
            ->where('book_id', $id)
            ->where('user_id', $user_id)
            ->where('status', 'pending')
            ->first();

        if (!$reservation) {
            return redirect()->back()
                ->with('error', 'Reservation not found or already processed.');
        }

        // OPTIONAL: role check (user can only cancel own reservation)
        if (!in_array($role_id, [1, 2, 3])) {
            return redirect()->back()
                ->with('error', 'You are not authorized.');
        }

        // UPDATE to cancelled
        $reservation_model
            ->where('id', $reservation['id'])
            ->set([
                'status' => 'cancelled',
                'remarks' => 'Cancelled by user',
                'updated_at' => date('Y-m-d H:i:s')
            ])
            ->update();

        return redirect()->back()
            ->with('success', 'Reservation cancelled successfully.');
    }
}
