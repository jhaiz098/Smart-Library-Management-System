<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\BorrowingModel;
use App\Models\UserModel;
use App\Models\FinesModel;

class Admin extends BaseController
{
    public function dashboard()
    {
        $book_model = new BookModel();
        $user_model = new UserModel();
        $borrowing_model = new BorrowingModel();
        $fine_model = new FinesModel();

        $totalBooks = $book_model->countAll();
        $totalUsers = $user_model->countAll();

        $activeBorrowed = $borrowing_model
            ->where('status', 'borrowed')
            ->countAllResults();

        $overdueBorrowed = $borrowing_model
            ->where('status', 'borrowed')
            ->where('due_date <', date('Y-m-d H:i:s'))
            ->countAllResults();

        $totalFines = $fine_model
            ->where('status', 'unpaid')
            ->countAllResults();

        $paidFines = $fine_model
            ->where('status', 'paid')
            ->countAllResults();

        $recentBorrowings = $borrowing_model

            ->select('
                borrowings.*,
                users.full_name,
                books.title
            ')
            ->join(
                'users',
                'users.id = borrowings.user_id'
            )
            ->join(
                'books',
                'books.id = borrowings.book_id'
            )
            ->orderBy(
                'borrowings.borrow_date',
                'DESC'
            )
            ->limit(5)
            ->findAll();

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
        $active_query = $book_model
            ->select('books.*, categories.name as category_name')
            ->join('categories', 'categories.id = books.category_id')
            ->where('books.status', 'active');

        // SEARCH
        if (!empty($search)) {
            $active_query->groupStart()
                ->like('title', $search)
                ->orLike('categories.name', $search)
                ->orLike('author', $search)
                ->orLike('publisher', $search)
                ->orLike('published_year', $search)
            ->groupEnd();
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

        $draft_query  = $book_model
            ->select('books.*, categories.name as category_name')
            ->join('categories', 'categories.id = books.category_id')
            ->where('status', 'draft');

        // SEARCH
        if (!empty($search)) {
            $draft_query->groupStart()
                ->like('title', $search)
                ->orLike('categories.name', $search)
                ->orLike('author', $search)
                ->orLike('publisher', $search)
                ->orLike('published_year', $search)
            ->groupEnd();
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
