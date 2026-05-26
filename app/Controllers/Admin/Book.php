<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\BorrowRequestModel;
use App\Models\BorrowRequestHistoryModel;
use App\Models\BorrowingModel;
use App\Models\UserModel;
use App\Models\LibrarySettingsModel;
use App\Models\ReservationModel;

class Book extends BaseController
{
    public function add_book()
    {
        $category_model = new CategoryModel();

        $data = [];
        $data['categories'] = $category_model->findAll();

        return view('admin/add_edit_book', $data);
    }

    public function view_book($id)
    {
        $book_model = new BookModel();
        $category_model = new CategoryModel();

        $data = [];
        $data['book'] = $book_model->find($id);
        
        $category = $category_model->find($data['book']['category_id']);
        $data['book']['category_name'] = $category['name'];

        return view('admin/view_book', $data);
    }
    
    public function edit_book($id = null)
    {
        $book_model = new BookModel();
        $category_model = new CategoryModel();

        $data = [];

        if ($id) {
            $data['book'] =  $book_model->find($id);
            $data['categories'] = $category_model->findAll();

            $category = $category_model->find($data['book']['category_id']);
            $data['book']['category_name'] = $category['name'];
        }

        return view('admin/add_edit_book', $data);
    }

    public function save_book()
    {
        $model = new BookModel();

        $id = $this->request->getPost('id');

        $data = [
            'category_id' => trim($this->request->getPost('category_id')),
            'title' => trim($this->request->getPost('title')),
            'author' => trim($this->request->getPost('author')),
            'description' => trim($this->request->getPost('description')),
            'published_year' => trim($this->request->getPost('published_year')),
            'publisher' => trim($this->request->getPost('publisher')),
            'status' => trim($this->request->getPost('status')),
            'availability' => "available",
        ];

        // CHECK FOR EMPTY FIELDS
        foreach ($data as $key => $value) {

            // skip availability since it's auto-set
            if ($key == 'availability') {
                continue;
            }

            if (empty($value)) {

                return redirect()->back()
                    ->withInput()
                    ->with('error', ucfirst(str_replace('_', ' ', $key)) . ' is required.');

            }
        }

        if ($id) {
            $model->update($id, $data);
        } else {
            $model->insert($data);
        }

        return redirect()->to('/admin/book_management')
            ->with('success', 'Book saved successfully.');
    }

    public function delete_book($id)
    {
        $model = new BookModel();
        $model->delete($id);

        return redirect()->to('/admin/book_management');
    }

    public function publish_book($id)
    {
        $model = new BookModel();

        $data = [
            'status' => 'active',
        ];

        $model->update($id, $data);

        return redirect()->to('/admin/book_management_draft');
    }

    public function unpublish_book($id)
    {
        $model = new BookModel();

        $data = [
            'status' => 'draft',
        ];
        
        $model->update($id, $data);

        return redirect()->to('/admin/book_management_active');
    }

    public function pending_borrow_requests_list()
    {
        $borrow_requests_model = new BorrowRequestModel();

        $perPage = 10;

        $borrow_requests_model->where('status', 'pending')
            ->where('expires_at <=', date('Y-m-d H:i:s'))
            ->set([
                'status' => 'expired',
                'remarks' => 'Automatically expired after reaching expiration date.'
            ])
            ->update();
        
        $baseQuery = $borrow_requests_model
            ->select('
                borrow_requests.*,
                borrower.library_id as library_id,
                borrower.full_name as full_name,
                books.title as book_title
            ')
            ->join('users as borrower', 'borrower.id = borrow_requests.user_id')
            ->join('books', 'books.id = borrow_requests.book_id');

        $pendingQuery = clone $baseQuery;

        $pending_requests = $pendingQuery
            ->where('borrow_requests.status', 'pending')
            ->paginate($perPage);

        return view('admin/borrow_requests/pending_borrow_requests_list', [
            'pending_requests' => $pending_requests,
            'pager' => $pendingQuery->pager,
            'request_status' => 'pending'
        ]);
    }

    public function approved_borrow_requests_list()
    {
        $borrow_requests_model = new BorrowRequestModel();

        $perPage = 10;

        $baseQuery = $borrow_requests_model
            ->select('
                borrow_requests.*,
                borrower.library_id as library_id,
                borrower.full_name as full_name,
                books.title as book_title,
                processor.library_id as processed_by_library_id,
                processor.full_name as processed_by_name
            ')
            ->join('users as borrower', 'borrower.id = borrow_requests.user_id')
            ->join('books', 'books.id = borrow_requests.book_id')
            ->join('users as processor', 'processor.id = borrow_requests.processed_by', 'left');

        $approvedQuery = clone $baseQuery;

        // PROCESSED
        $approved_requests = $approvedQuery
            ->where('borrow_requests.status', ['approved',])
            ->paginate($perPage);

        return view('admin/borrow_requests/approved_borrow_requests_list', [
            'approved_requests' => $approved_requests,
            'pager' => $approvedQuery->pager,
            'request_status' => 'approved'
        ]);
    }

    public function expired_borrow_requests_list()
    {
        $borrow_requests_model = new BorrowRequestModel();

        $perPage = 10;

        $baseQuery = $borrow_requests_model
            ->select('
                borrow_requests.*,
                borrower.library_id as library_id,
                borrower.full_name as full_name,
                books.title as book_title,
                processor.library_id as processed_by_library_id,
                processor.full_name as processed_by_name
            ')
            ->join('users as borrower', 'borrower.id = borrow_requests.user_id')
            ->join('books', 'books.id = borrow_requests.book_id')
            ->join('users as processor', 'processor.id = borrow_requests.processed_by', 'left');

        $expiredQuery = clone $baseQuery;

        // PROCESSED
        $expired_requests = $expiredQuery
            ->where('borrow_requests.status', ['expired',])
            ->paginate($perPage);

        return view('admin/borrow_requests/expired_borrow_requests_list', [
            'expired_requests' => $expired_requests,
            'pager' => $expiredQuery->pager,
            'request_status' => 'expired'
        ]);
    }
    
    public function completed_borrow_requests_list()
    {
        $borrow_requests_model = new BorrowRequestModel();

        $perPage = 10;

        $baseQuery = $borrow_requests_model
            ->select('
                borrow_requests.*,
                borrower.library_id as library_id,
                borrower.full_name as full_name,
                books.title as book_title,
                processor.library_id as processed_by_library_id,
                processor.full_name as processed_by_name
            ')
            ->join('users as borrower', 'borrower.id = borrow_requests.user_id')
            ->join('books', 'books.id = borrow_requests.book_id')
            ->join('users as processor', 'processor.id = borrow_requests.processed_by', 'left');

        $completedQuery = clone $baseQuery;

        // PROCESSED
        $completed_requests = $completedQuery
            ->whereIn('borrow_requests.status', [
                'claimed',
                'rejected',
                'cancelled',
            ])
            ->paginate($perPage);

        return view('admin/borrow_requests/completed_borrow_requests_list', [
            'completed_requests' => $completed_requests,
            'pager' => $completedQuery->pager,
            'request_status' => 'completed'
        ]);
    }

    public function pending_borrow_requests_reject($id)
    {
        $borrow_requests_model = new BorrowRequestModel();
        $borrow_requests_history_model = new BorrowRequestHistoryModel();

        $user_id = session()->get('user_id');
        $remarks = $this->request->getPost('remarks');

        $borrow_requests_model->update($id, [
            'status' => 'rejected',
            'processed_at' => date('Y-m-d H:i:s'),
            'processed_by' => $user_id,
            'remarks' => $remarks
        ]);

        $borrow_requests_history_model->insert([
            'borrow_request_id' => $id,
            'action' => 'rejected',
            'performed_at' => date('Y-m-d H:i:s'),
            'performed_by' => $user_id,
            'remarks' => $remarks
        ]);

        return redirect()->back()
            ->with('success', 'Borrow request rejected successfully.');
    }

    public function pending_borrow_requests_approve($id)
    {
        $borrow_requests_model = new BorrowRequestModel();
        $borrow_requests_history_model = new BorrowRequestHistoryModel();

        $role_id = (int) session()->get('role_id');
        $user_id = session()->get('user_id');

        // ROLE CHECK (adjust based on your system)
        if (!in_array($role_id, [1, 2])) {
            return redirect()->back()
                ->with('error', 'You are not authorized to approve requests.');
        }

        // determine role label
        $role_label = match ($role_id) {
            1 => 'Admin',
            2 => 'Staff',
            default => 'Unknown'
        };

        $borrow_requests_model->update($id, [
            'status' => 'approved',
            'processed_at' => date('Y-m-d H:i:s'),
            'processed_by' => $user_id,
            'remarks' => "Approved by {$role_label}"
        ]);

        $borrow_requests_history_model->insert([
            'borrow_request_id' => $id,
            'action' => 'approved',
            'performed_at' => date('Y-m-d H:i:s'),
            'performed_by' => $user_id,
            'remarks' => "Approved by {$role_label}"
        ]);

        $claim_code = "BRW-" . date('Y') . "-" . str_pad($id, 6, '0', STR_PAD_LEFT);

        $borrow_requests_model->update($id, [
            'claim_code' => $claim_code
        ]);

        return redirect()->back()
            ->with('success', 'Borrow request approved successfully.');
    }

    public function approved_borrow_requests_claim($id)
    {
        $borrow_request_model = new BorrowRequestModel();
        $history_model = new BorrowRequestHistoryModel();
        $borrowing_model = new BorrowingModel();
        $reservation_model = new ReservationModel();
        $library_settings_model = new LibrarySettingsModel();
        $book_model = new BookModel();

        $role_id = (int) session()->get('role_id');

        $request = $borrow_request_model->find($id);
        $borrow_days = $library_settings_model->first()['borrow_days'];

        // ROLE CHECK (adjust based on your system)
        if (!in_array($role_id, [1, 2])) {
            return redirect()->back()
                ->with('error', 'You are not authorized to approve requests.');
        }

        // determine role label
        $role_label = match ($role_id) {
            1 => 'Admin',
            2 => 'Staff',
            default => 'Unknown'
        };
        
        // check if request exists
        if (!$request) {
            return redirect()->back()
                ->with('error', 'Borrow request not found.');
        }

        // only approved requests can be claimed
        if ($request['status'] !== 'approved') {
            return redirect()->back()
                ->with('error', 'Only approved requests can be claimed.');
        }

        // update request
        $borrow_request_model->update($id, [
            'status' => 'claimed',
            'processed_at' => date('Y-m-d H:i:s'),
            'processed_by' => session()->get('user_id'),
            'remarks' => $this->request->getPost('remarks') ?: "Book marked as claimed successfully by {$role_label}."
        ]);

        // history log
        $history_model->insert([
            'borrow_request_id' => $id,
            'action' => 'claimed',
            'performed_at' => date('Y-m-d H:i:s'),
            'performed_by' => session()->get('user_id'),
            'remarks' => $this->request->getPost('remarks') ?: "Book marked as claimed successfully by {$role_label}."
        ]);

        $borrowing_model->insert([
            'borrow_request_id' => $request['id'],

            'user_id' => $request['user_id'],
            'book_id' => $request['book_id'],

            'borrow_date' => date('Y-m-d H:i:s'),

            // example: 7 days borrowing
            'due_date' => date('Y-m-d H:i:s', strtotime("+{$borrow_days} days")),

            'status' => 'borrowed',

            'issued_by' => session()->get('user_id'),

            'remarks' => $this->request->getPost('remarks') ?: "Book marked as claimed successfully by {$role_label}."
        ]);

        $book_model->update($request['book_id'], [
            'availability' => 'borrowed'
        ]);

        $reservation = $reservation_model
            ->where('user_id', $request['user_id'])
            ->where('book_id', $request['book_id'])
            ->whereIn('status', ['pending', 'ready'])
            ->first();

        if ($reservation) {

            $reservation_model->update($reservation['id'], [
                'status' => 'fulfilled',
                'updated_at' => date('Y-m-d H:i:s')
            ]);
        }

        return redirect()->back()
            ->with('success', 'Book marked as claimed successfully.');
    }



    public function approved_borrow_requests_cancel($id)
    {
        $borrow_request_model = new BorrowRequestModel();
        $history_model = new BorrowRequestHistoryModel();

        $role_id = (int) session()->get('role_id');

        $request = $borrow_request_model->find($id);

        // ROLE CHECK (adjust based on your system)
        if (!in_array($role_id, [1, 2])) {
            return redirect()->back()
                ->with('error', 'You are not authorized to approve requests.');
        }

        // determine role label
        $role_label = match ($role_id) {
            1 => 'Admin',
            2 => 'Staff',
            default => 'Unknown'
        };

        // check if request exists
        if (!$request) {
            return redirect()->back()
                ->with('error', 'Borrow request not found.');
        }

        // only approved requests can be cancelled
        if ($request['status'] !== 'approved') {
            return redirect()->back()
                ->with('error', 'Only approved requests can be cancelled.');
        }

        // update request
        $borrow_request_model->update($id, [
            'status' => 'cancelled',
            'processed_at' => date('Y-m-d H:i:s'),
            'processed_by' => session()->get('user_id'),
            'remarks' => $this->request->getPost('remarks') ?: "Approved request cancelled by {$role_label}."
        ]);

        // history log
        $history_model->insert([
            'borrow_request_id' => $id,
            'action' => 'cancelled',
            'performed_at' => date('Y-m-d H:i:s'),
            'performed_by' => session()->get('user_id'),
            'remarks' => $this->request->getPost('remarks') ?: "Approved request cancelled by {$role_label}."
        ]);

        return redirect()->back()
            ->with('success', 'Approved borrow request cancelled successfully.');
    }

    
}







