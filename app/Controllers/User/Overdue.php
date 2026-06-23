<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;

class Overdue extends BaseController
{
    public function list()
    {
        $borrowing_model = new \App\Models\BorrowingModel();
        $library_settings_model = new \App\Models\LibrarySettingsModel();

        $user_id = session()->get('user_id');
        $perPage = 10;

        $settings = $library_settings_model->first();

        $dailyFine = (float) $settings['daily_overdue_fine'];
        $maxFine = (float) $settings['max_fine_amount'];

        $borrowings = $borrowing_model
            ->select('
                borrowings.*,
                books.title,
                books.author
            ')
            ->join('books', 'books.id = borrowings.book_id')
            ->where('borrowings.user_id', $user_id)
            ->where('borrowings.status', 'borrowed')
            ->where('borrowings.due_date <', date('Y-m-d H:i:s'))
            ->orderBy('borrowings.due_date', 'ASC')
            ->paginate($perPage);

        foreach ($borrowings as &$borrowing) {

            $dueDate = strtotime($borrowing['due_date']);
            $today = time();

            $daysOverdue = (int) ceil(($today - $dueDate) / 86400);

            $daysOverdue = max(1, $daysOverdue);

            $currentFine = $daysOverdue * $dailyFine;

            $isCapped = false;

            if ($maxFine > 0 && $currentFine >= $maxFine) {
                $currentFine = $maxFine;
                $isCapped = true;
            }

            $borrowing['days_overdue'] = $daysOverdue;
            $borrowing['current_fine'] = $currentFine;
            $borrowing['is_capped'] = $isCapped;
            $borrowing['max_fine_amount'] = $maxFine;
        }

        return view('user/overdue', [
            'borrowings' => $borrowings,
            'daily_overdue_fine' => $dailyFine,
            'max_fine_amount' => $maxFine,
            'pager' => $borrowing_model->pager
        ]);
    }
}
