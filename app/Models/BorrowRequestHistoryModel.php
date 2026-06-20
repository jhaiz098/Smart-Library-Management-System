<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class BorrowRequestHistoryModel extends Model
    {
        protected $table = 'borrow_request_history';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'borrow_request_id',
            'action',
            'performed_at',
            'performed_by',
            'remarks',
        ];
    }

?>