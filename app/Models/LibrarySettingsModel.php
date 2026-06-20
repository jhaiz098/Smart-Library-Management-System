<?php

namespace App\Models;
use CodeIgniter\Model;

class LibrarySettingsModel extends Model
{
    protected $table = 'library_settings';
    protected $primaryKey = 'id';
    protected $returnType = 'array';

    protected $allowedFields = [
        'borrow_days',
        'max_borrow_books',
        'max_reservation_books',
        'reservation_expiry_days',
        'daily_overdue_fine',
        'max_fine_amount',
    ];

    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
}

?>