<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ReservationModel;

class Reservations extends BaseController
{
    public function list()
    {
        $reservation_model = new ReservationModel();

        /*
        |--------------------------------------------------------------------------
        | AUTO EXPIRE RESERVATIONS
        |--------------------------------------------------------------------------
        */

        $expiredReservations = $reservation_model

            ->where('status', 'pending')

            ->where('expiration_date IS NOT NULL')

            ->where('expiration_date <', date('Y-m-d H:i:s'))

            ->findAll();

        foreach ($expiredReservations as $expired) {

            // expire current reservation
            $reservation_model->update($expired['id'], [
                'status' => 'expired'
            ]);

            /*
            |--------------------------------------------------------------------------
            | ACTIVATE NEXT RESERVER
            |--------------------------------------------------------------------------
            */

            $nextReservation = $reservation_model

                ->where('book_id', $expired['book_id'])

                ->where('status', 'pending')

                ->where('expiration_date IS NULL')

                ->orderBy('reservation_date', 'ASC')

                ->first();

            if ($nextReservation) {

                $reservation_model->update($nextReservation['id'], [

                    'expiration_date' => date(
                        'Y-m-d H:i:s',
                        strtotime('+3 days')
                    )

                ]);
            }
        }

        $perPage = 10;

        $type = $this->request->getGet('type') ?? 'all';
        $search = trim($this->request->getGet('search') ?? '');
        $sort = $this->request->getGet('sort') ?? '';
        $status = $this->request->getGet('status') ?? '';

        $query = $reservation_model

            ->select('
                reservations.*,

                users.library_id,
                users.full_name,

                books.title as book_title,

                processor.full_name as processed_by_name
            ')

            ->join(
                'users',
                'users.id = reservations.user_id'
            )

            ->join(
                'books',
                'books.id = reservations.book_id'
            )

            ->join(
                'users as processor',
                'processor.id = reservations.processed_by',
                'left'
            );

        /*
        |--------------------------------------------------------------------------
        | NAV FILTER
        |--------------------------------------------------------------------------
        */

        switch ($type) {

            case 'pending':
                $query->where('reservations.status', 'pending');
                break;

            case 'fulfilled':
                $query->where('reservations.status', 'fulfilled');
                break;

            case 'expired':
                $query->where('reservations.status', 'expired');
                break;

            case 'cancelled':
                $query->where('reservations.status', 'cancelled');
                break;

            case 'all':
            default:
                break;
        }

        /*
        |--------------------------------------------------------------------------
        | STATUS FILTER DROPDOWN
        |--------------------------------------------------------------------------
        */

        if (!empty($status)) {

            $query->where(
                'reservations.status',
                $status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if (!empty($search)) {

            $query->groupStart()

                ->like(
                    'users.library_id',
                    $search
                )

                ->orLike(
                    'users.full_name',
                    $search
                )

                ->orLike(
                    'books.title',
                    $search
                )

            ->groupEnd();
        }

        /*
        |--------------------------------------------------------------------------
        | SORT
        |--------------------------------------------------------------------------
        */

        switch ($sort) {

            case 'oldest':
                $query->orderBy(
                    'reservations.reservation_date',
                    'ASC'
                );
                break;

            case 'expiration_asc':
                $query->orderBy(
                    'reservations.expiration_date',
                    'ASC'
                );
                break;

            case 'expiration_desc':
                $query->orderBy(
                    'reservations.expiration_date',
                    'DESC'
                );
                break;

            case 'newest':
            default:
                $query->orderBy(
                    'reservations.reservation_date',
                    'DESC'
                );
                break;
        }

        $records = $query->paginate($perPage);

        /*
        |--------------------------------------------------------------------------
        | QUEUE POSITION
        |--------------------------------------------------------------------------
        */

        foreach ($records as &$reservation) {

            // only pending reservations belong to queue
            if ($reservation['status'] !== 'pending') {

                $reservation['queue_position'] = null;
                continue;
            }

            $position = $reservation_model

                ->where('book_id', $reservation['book_id'])

                ->where('status', 'pending')

                ->where('reservation_date <=', $reservation['reservation_date'])

                ->countAllResults();

            $reservation['queue_position'] = $position;
        }

        unset($reservation);
        return view('admin/reservations', [

            'records' => $records,

            'pager' => $reservation_model->pager,

            'reservation_status' => $type,

            'search' => $search,

            'sort' => $sort,

            'status' => $status
        ]);
    }
}