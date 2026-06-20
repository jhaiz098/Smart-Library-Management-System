<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class BorrowingHistory extends Model
    {
        protected $table = 'borrowing_history';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'borrowing_id',
            'action',
            'previous_due_date',
            'new_due_date',
            'performed_at',
            'performed_by',
            'remarks',
        ];
    }

?>