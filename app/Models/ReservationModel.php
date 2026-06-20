<?php

    namespace App\Models;
    use CodeIgniter\Model;

    class ReservationModel extends Model
    {
        protected $table = 'reservations';
        protected $primaryKey = 'id';
        protected $returnType = 'array';

        protected $allowedFields = [
            'user_id',
            'book_id',
            'reservation_date',
            'expiration_date',
            'status',
            'processed_at',
            'processed_by',
            'remarks',
        ];

        protected $useTimestamps = true;
        protected $createdField = 'created_at';
        protected $updatedField = 'updated_at';
    }

?>