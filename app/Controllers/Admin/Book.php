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
            'category_id'     => trim($this->request->getPost('category_id')),
            'title'           => trim($this->request->getPost('title')),
            'author'          => trim($this->request->getPost('author')),
            'description'     => trim($this->request->getPost('description')),
            'published_year'  => trim($this->request->getPost('published_year')),
            'publisher'       => trim($this->request->getPost('publisher'))
        ];

        // validation
        foreach ($data as $key => $value) {

            if (empty($value)) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', ucfirst(str_replace('_', ' ', $key)) . ' is required.');
            }
        }

        if ($id) {

            // EDIT
            $model->update($id, $data);

        } else {

            // ADD
            $data['status'] = 'active';

            $model->insert($data);
        }

        return redirect()->to('/admin/book_management_active')
            ->with('success', $id ? 'Book updated successfully.' : 'Book added successfully.');
    }

    public function delete_book($id)
    {
        $model = new BookModel();

        $book = $model->find($id);

        if (!$book) {
            return redirect()->back()
                ->with('error', 'Book not found.');
        }

        // Prevent deleting borrowed books
        if ($book['availability'] === 'borrowed') {
            return redirect()->back()
                ->with(
                    'error',
                    'This book cannot be deleted because it is currently borrowed.'
                );
        }

        try {

            if (!$model->delete($id)) {
                return redirect()->back()
                    ->with('error', 'Failed to delete book.');
            }

            return redirect()->back()
                ->with('success', 'Book deleted successfully.');

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', 'Something went wrong while deleting the book.');
        }
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

        $book = $model->find($id);

        if (!$book) {
            return redirect()->back()
                ->with('error', 'Book not found.');
        }

        // Prevent unpublishing borrowed books
        if ($book['availability'] === 'borrowed') {
            return redirect()->back()
                ->with(
                    'error',
                    'This book cannot be unpublished because it is currently borrowed.'
                );
        }

        $updated = $model->update($id, [
            'status' => 'draft'
        ]);

        if (!$updated) {
            return redirect()->back()
                ->with('error', 'Failed to unpublish book.');
        }

        return redirect()->to('/admin/book_management_active')
            ->with('success', 'Book unpublished successfully.');
    }

    public function borrow_requests_list()
    {
        if (!session()->get('can_manage_borrow_requests') == 1) {
            return redirect()->back()
                ->with('error', 'Access denied.');
        }

        $borrow_requests_model = new BorrowRequestModel();

        $perPage = 10;

        // Auto-expire approved requests
        $borrow_requests_model
            ->where('status', 'approved')
            ->where('expires_at <=', date('Y-m-d H:i:s'))
            ->set([
                'status' => 'expired',
                'remarks' => 'Automatically expired after reaching expiration date.'
            ])
            ->update();

        $type = $this->request->getGet('type') ?? 'all';
        $search = trim($this->request->getGet('search') ?? '');
        $sort = $this->request->getGet('sort') ?? 'newest';

        $query = $borrow_requests_model
            ->select('
                borrow_requests.*,

                borrower.library_id as library_id,
                borrower.full_name as full_name,

                books.title as book_title
            ')
            ->join('users as borrower', 'borrower.id = borrow_requests.user_id')
            ->join('books', 'books.id = borrow_requests.book_id');

        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER
        |--------------------------------------------------------------------------
        */

        switch ($type) {

            case 'pending':
                $query->where('borrow_requests.status', 'pending');
                break;

            case 'approved':
                $query->where('borrow_requests.status', 'approved');
                break;

            case 'completed':
                $query->whereIn('borrow_requests.status', [
                    'cancelled',
                    'rejected',
                    'claimed'
                ]);
                break;

            case 'expired':
                $query->where('borrow_requests.status', 'expired');
                break;

            case 'all':
            default:
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if (!empty($search)) {

            $query->groupStart()

                ->like('borrow_requests.borrow_request_code', $search)

                ->orLike('borrower.library_id', $search)

                ->orLike('borrower.full_name', $search)

                ->orLike('books.title', $search)

            ->groupEnd();
        }

        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            case 'code_asc':
                $query->orderBy('borrow_requests.borrow_request_code', 'ASC');
                break;

            case 'code_desc':
                $query->orderBy('borrow_requests.borrow_request_code', 'DESC');
                break;

            case 'oldest':
                $query->orderBy('borrow_requests.request_date', 'ASC');
                break;

            case 'newest':
            default:
                $query->orderBy('borrow_requests.request_date', 'DESC');
                break;
        }

        $records = $query->paginate($perPage);

        return view('admin/borrow_requests', [
            'records' => $records,
            'pager' => $borrow_requests_model->pager,

            'request_status' => $type,

            'search' => $search,
            'sort' => $sort
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
        $library_settings_model = new LibrarySettingsModel();

        $role_id = (int) session()->get('role_id');
        $user_id = session()->get('user_id');

        // ROLE CHECK
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

        $settings = $library_settings_model->first();

        $reservation_expiry_days = (int) ($settings['reservation_expiry_days'] ?? 3);

        $borrow_requests_model->update($id, [
            'status' => 'approved',
            'processed_at' => date('Y-m-d H:i:s'),
            'processed_by' => $user_id,
            'remarks' => "Approved by {$role_label}",
            'expires_at' => date(
                'Y-m-d 23:59:59',
                strtotime("+{$reservation_expiry_days} days")
            )
        ]);

        $borrow_requests_history_model->insert([
            'borrow_request_id' => $id,
            'action' => 'approved',
            'performed_at' => date('Y-m-d H:i:s'),
            'performed_by' => $user_id,
            'remarks' => "Approved by {$role_label}"
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

        // ROLE CHECK
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

            'due_date' => date('Y-m-d 23:59:59', strtotime("+{$borrow_days} days")),
            'status' => 'borrowed',

            'issued_by' => session()->get('user_id'),

            'remarks' => $this->request->getPost('remarks') ?: "Book marked as claimed successfully by {$role_label}."
        ]);

        $borrowing_id = $borrowing_model->insertID();

        $borrowing_code = 'BRW-' . date('Y') . '-' . str_pad($borrowing_id, 6, '0', STR_PAD_LEFT);

        $borrowing_model->update($borrowing_id, [
            'borrowing_code' => $borrowing_code
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







