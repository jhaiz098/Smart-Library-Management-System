<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\BorrowingModel;
use App\Models\BorrowRequestModel;
use App\Models\ReservationModel;
use App\Models\UserModel;

class Transactions extends BaseController
{
    public function borrowings_list()
    {
        $user_id = session()->get('user_id');

        $borrowing_model = new BorrowingModel();
        $borrow_request_model = new BorrowRequestModel();
        $reservation_model = new ReservationModel();

        // CURRENT BORROWINGS
        $borrowings = $borrowing_model
            ->select('
                borrowings.*,
                books.title,
                books.author
            ')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('borrowings.user_id', $user_id)
            ->orderBy('borrowings.created_at', 'DESC')
            ->findAll();

        // BORROW REQUESTS
        $borrow_requests = $borrow_request_model
            ->select('
                borrow_requests.*,
                books.title,
                books.author
            ')
            ->join('books', 'books.id = borrow_requests.book_id')
            ->where('borrow_requests.user_id', $user_id)
            ->orderBy('borrow_requests.created_at', 'DESC')
            ->findAll();

        // RESERVATIONS
        $reservations = $reservation_model
            ->select('
                reservations.*,
                books.title,
                books.author
            ')
            ->join('books', 'books.id = reservations.book_id')
            ->where('reservations.user_id', $user_id)
            ->orderBy('reservations.created_at', 'DESC')
            ->findAll();

        return view('user/my_transactions/borrowings', [
            'borrowings' => $borrowings,
            'borrow_requests' => $borrow_requests,
            'reservations' => $reservations,
            'transaction_type' => 'borrowings'
        ]);
    }

    public function borrow_requests_list()
    {
        $user_id = session()->get('user_id');

        $borrow_request_model = new BorrowRequestModel();

        // BORROW REQUESTS
        $borrow_requests = $borrow_request_model
            ->select('
                borrow_requests.*,
                books.title,
                books.author
            ')
            ->join('books', 'books.id = borrow_requests.book_id')
            ->where('borrow_requests.user_id', $user_id)
            ->orderBy('borrow_requests.created_at', 'DESC')
            ->findAll();


        return view('user/my_transactions/borrow_requests', [
            'borrow_requests' => $borrow_requests,
            'transaction_type' => 'borrow_requests'
        ]);
    }

    public function reservations_list()
    {
        $user_id = session()->get('user_id');

        $reservation_model = new ReservationModel();

        $perPage = 10;

        // PAGINATED RESERVATIONS
        $reservations = $reservation_model
            ->select('
                reservations.*,
                books.title,
                books.author
            ')
            ->join('books', 'books.id = reservations.book_id')
            ->where('reservations.user_id', $user_id)
            ->orderBy('reservations.created_at', 'DESC')
            ->paginate($perPage);

        // COMPUTE QUEUE POSITION
        foreach ($reservations as &$reservation) {

            $queue_model = new ReservationModel();

            $queue_position = $queue_model
                ->where('book_id', $reservation['book_id'])
                ->whereIn('status', ['pending', 'ready'])
                ->where('id <=', $reservation['id'])
                ->countAllResults();

            $reservation['queue_position'] = $queue_position;
        }

        return view('user/my_transactions/reservations', [
            'reservations' => $reservations,
            'pager' => $reservation_model->pager,
            'transaction_type' => 'reservations'
        ]);
    }

    public function all_list()
    {
        $user_id = session()->get('user_id');
        $perPage = 10;
        $page = $this->request->getGet('page') ?? 1;

        $db = \Config\Database::connect();

        $sql = "
            SELECT borrowings.id, borrowings.book_id, borrowings.created_at, books.title, books.author, 'borrowing' AS transaction_type
            FROM borrowings
            JOIN books ON books.id = borrowings.book_id
            WHERE borrowings.user_id = ?

            UNION ALL

            SELECT borrow_requests.id, borrow_requests.book_id, borrow_requests.created_at, books.title, books.author, 'borrow_request' AS transaction_type
            FROM borrow_requests
            JOIN books ON books.id = borrow_requests.book_id
            WHERE borrow_requests.user_id = ?

            UNION ALL

            SELECT reservations.id, reservations.book_id, reservations.created_at, books.title, books.author, 'reservation' AS transaction_type
            FROM reservations
            JOIN books ON books.id = reservations.book_id
            WHERE reservations.user_id = ?

            ORDER BY created_at DESC
        ";

        $query = $db->query($sql, [$user_id, $user_id, $user_id]);
        $results = $query->getResultArray();

        // TOTAL COUNT
        $total = count($results);

        // MANUAL PAGINATION (THIS IS THE KEY)
        $transactions = array_slice(
            $results,
            ($page - 1) * $perPage,
            $perPage
        );

        // CI4 pager
        $pager = \Config\Services::pager();
        $pager->makeLinks($page, $perPage, $total);

        return view('user/my_transactions/all', [
            'transactions' => $transactions,
            'pager' => $pager,
            'total' => $total,
            'perPage' => $perPage,
            'page' => $page,
            'transaction_type' => 'all'
        ]);
    }
}
