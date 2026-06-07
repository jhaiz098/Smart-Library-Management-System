<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\BorrowingModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $db = \Config\Database::connect();

        // TOTAL COUNTS
        $totalBooks = $db->table('books')->countAll();
        $totalUsers = $db->table('users')->countAll();

        $activeBorrowed = $db->table('borrowings')
            ->where('status', 'borrowed')
            ->countAllResults();

        $overdueBorrowed = $db->table('borrowings')
            ->where('status', 'borrowed')
            ->where('due_date <', date('Y-m-d H:i:s'))
            ->countAllResults();

        $totalFines = $db->table('fines')
            ->where('status', 'unpaid')
            ->countAllResults();

        $paidFines = $db->table('fines')
            ->where('status', 'paid')
            ->countAllResults();

        // RECENT BORROWINGS
        $recentBorrowings = $db->table('borrowings')
            ->select('borrowings.*, users.full_name, books.title')
            ->join('users', 'users.id = borrowings.user_id')
            ->join('books', 'books.id = borrowings.book_id')
            ->orderBy('borrowings.borrow_date', 'DESC')
            ->limit(5)
            ->get()
            ->getResultArray();

        return view('admin/dashboard', [
            'totalBooks' => $totalBooks,
            'totalUsers' => $totalUsers,
            'activeBorrowed' => $activeBorrowed,
            'overdueBorrowed' => $overdueBorrowed,
            'totalFines' => $totalFines,
            'paidFines' => $paidFines,
            'recentBorrowings' => $recentBorrowings
        ]);
    }

    public function book_management_active()
    {
        if (!session()->get('can_manage_books') == 1) {
            return redirect()->back()
                ->with('error', 'Access denied.');
        }

        $book_model = new BookModel();
        $category_model = new CategoryModel();

        $search = $this->request->getGet('search') ?? "";
        $sort = $this->request->getGet('sort') ?? "";
        $category = $this->request->getGet('category') ?? "";

        $perPage = 10;

        // SEPARATE INSTANCES
        $active_query = (new BookModel())->where('status', 'active');

        // SEARCH
        if (!empty($search)) {
            $active_query->like('title', $search);
        }

        // CATEGORY FILTER (DB BASED)
        if (!empty($category)) {
            $active_query->where('category_id', $category);
        }

        // SORT
        if ($sort == 'title_asc') {
            $active_query->orderBy('title', 'ASC');
        }
        elseif ($sort == 'title_desc') {
            $active_query->orderBy('title', 'DESC');
        }
        elseif ($sort == 'newest') {
            $active_query->orderBy('created_at', 'DESC');
        }
        elseif ($sort == 'oldest') {
            $active_query->orderBy('created_at', 'ASC');
        }

        $active_books = $active_query->paginate($perPage, 'active');
        $active_pager = $active_query->pager;

        // CATEGORY NAME ATTACHMENT
        foreach ($active_books as &$book) {
            $category_data = $category_model->find($book['category_id']);
            $book['category_name'] = $category_data['name'] ?? '';
        }

        // ALL CATEGORIES (FOR FILTER DROPDOWN)
        $categories = $category_model->findAll();

        return view('book_management/book_management_active', [
            'active_books' => $active_books,

            'active_pager' => $active_pager,

            'search' => $search,
            'sort' => $sort,
            'category' => $category,
            'categories' => $categories,
            'book_status' => 'active'
        ]);
    }

    public function book_management_draft()
    {
        $book_model = new BookModel();
        $category_model = new CategoryModel();

        $search = $this->request->getGet('search') ?? "";
        $sort = $this->request->getGet('sort') ?? "";
        $category = $this->request->getGet('category') ?? "";

        $perPage = 10;

        // SEPARATE INSTANCES
        $draft_query  = (new BookModel())->where('status', 'draft');

        // SEARCH
        if (!empty($search)) {
            $draft_query->like('title', $search);
        }

        // CATEGORY FILTER (DB BASED)
        if (!empty($category)) {
            $draft_query->where('category_id', $category);
        }

        // SORT
        if ($sort == 'title_asc') {
            $draft_query->orderBy('title', 'ASC');
        }
        elseif ($sort == 'title_desc') {
            $draft_query->orderBy('title', 'DESC');
        }
        elseif ($sort == 'newest') {
            $draft_query->orderBy('created_at', 'DESC');
        }
        elseif ($sort == 'oldest') {
            $draft_query->orderBy('created_at', 'ASC');
        }

        $draft_books = $draft_query->paginate($perPage, 'draft');
        $draft_pager = $draft_query->pager;

        foreach ($draft_books as &$book) {
            $category_data = $category_model->find($book['category_id']);
            $book['category_name'] = $category_data['name'] ?? '';
        }

        // ALL CATEGORIES (FOR FILTER DROPDOWN)
        $categories = $category_model->findAll();

        return view('book_management/book_management_draft', [
            'draft_books' => $draft_books,

            'draft_pager' => $draft_pager,

            'search' => $search,
            'sort' => $sort,
            'category' => $category,
            'categories' => $categories,
            'book_status' => 'draft'
        ]);
    }
}
