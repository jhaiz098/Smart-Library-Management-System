<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class FinesModel extends Model
    {
        protected $table = 'fines';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'borrowing_id',
            'user_id',
            'amount',
            'remarks',
            'status',
            'issued_by',
            'paid_at',
            'paid_by',
        ];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
    }

?>