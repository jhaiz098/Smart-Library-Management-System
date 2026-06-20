<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class BorrowRequestModel extends Model
    {
        protected $table = 'borrow_requests';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'user_id',
            'book_id',
            'status',
            'request_date',
            'processed_at',
            'processed_by',
            'remarks',
            'claim_code',
        ];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
    }

?>