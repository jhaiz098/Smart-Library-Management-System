<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class BorrowingModel extends Model
    {
        protected $table = 'borrowings';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'borrow_request_id',
            'user_id',
            'book_id',
            'borrowing_code',
            'borrow_date',
            'due_date',
            'return_date',
            'status',
            'issued_by',
            'returned_to',
            'remarks',
        ];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
    }

?>