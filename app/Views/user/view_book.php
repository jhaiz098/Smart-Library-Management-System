<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | View Book
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    View Book
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid p-3">

    <a href="/user/books" class="btn btn-secondary mb-3">
        ← Back
    </a>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row g-3">

        <!-- LEFT -->
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body p-4">

                            <div class="row align-items-center">

                                <div class="col-auto">

                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center"
                                        style="width:80px;height:80px;">

                                        <i class="bi bi-book-fill text-primary fs-2"></i>

                                    </div>

                                </div>

                                <div class="col">

                                    <span class="badge bg-light text-dark border mb-2">
                                        <?= esc($book['category_name']) ?>
                                    </span>

                                    <h2 class="fw-bold mb-1">
                                        <?= esc($book['title']) ?>
                                    </h2>

                                    <div class="text-muted">
                                        by <?= esc($book['author']) ?>
                                    </div>

                                </div>

                                <div class="col-auto">

                                    <?php if($book['availability'] === 'available'): ?>

                                        <span class="badge bg-success fs-6 px-3 py-2">
                                            <i class="bi bi-check-circle-fill me-1"></i>
                                            Available
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                            <i class="bi bi-clock-fill me-1"></i>
                                            Borrowed
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>
                    </div>

                    <hr>

                    <div class="row g-3 mb-4">

                        <div class="col-md-6">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="small text-muted mb-1">
                                    Publisher
                                </div>

                                <div class="fw-semibold">
                                    <?= esc($book['publisher']) ?>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="border rounded-3 p-3 h-100">

                                <div class="small text-muted mb-1">
                                    Published Year
                                </div>

                                <div class="fw-semibold">
                                    <?= esc($book['published_year']) ?>
                                </div>

                            </div>

                        </div>

                    </div>
                    
                    <div class="border rounded p-3">

                        <div class="card border-0 bg-light">

                            <div class="card-body">

                                <div class="fw-semibold mb-3">
                                    <i class="bi bi-file-text me-2"></i>
                                    Description
                                </div>

                                <div class="text-secondary" style="line-height:1.8;">
                                    <?= nl2br(esc($book['description'])) ?>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <div class="card border-0 shadow-sm mt-4">

                <div class="card-header bg-white fw-bold">

                    <i class="bi bi-info-circle-fill text-primary me-2"></i>
                    Borrowing Rules

                </div>

                <div class="card-body">

                    <div class="d-flex mb-3">

                        <div class="me-3 text-primary">
                            <i class="bi bi-calendar-check fs-5"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">
                                Return Books On Time
                            </div>

                            <div class="small text-muted">
                                Books must be returned on or before their due date.
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex mb-3">

                        <div class="me-3 text-warning">
                            <i class="bi bi-cash-coin fs-5"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">
                                Daily Overdue Fine
                            </div>

                            <div class="small text-muted">
                                Overdue books incur a fine of
                                <strong>
                                    ₱<?= number_format($library_settings['daily_overdue_fine'], 2) ?>
                                </strong>
                                per day.
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex mb-3">

                        <div class="me-3 text-danger">
                            <i class="bi bi-exclamation-octagon-fill fs-5"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">
                                Maximum Fine Limit
                            </div>

                            <div class="small text-muted">
                                Fine charges stop once the maximum amount of
                                <strong>
                                    ₱<?= number_format($library_settings['max_fine_amount'], 2) ?>
                                </strong>
                                has been reached.
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex mb-3">

                        <div class="me-3 text-secondary">
                            <i class="bi bi-lock-fill fs-5"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">
                                Borrowing Restrictions
                            </div>

                            <div class="small text-muted">
                                Users with unpaid fines may have restricted borrowing privileges.
                            </div>
                        </div>

                    </div>

                    <hr>

                    <div class="d-flex">

                        <div class="me-3 text-success">
                            <i class="bi bi-box-seam-fill fs-5"></i>
                        </div>

                        <div>
                            <div class="fw-semibold">
                                Claim Approved Requests
                            </div>

                            <div class="small text-muted">
                                Approved borrow requests must be claimed before they expire.
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="col-lg-5">

            <!-- CURRENT BORROWER -->
            <div class="card border-0 shadow-sm mb-3">

                <div class="card-header bg-white fw-semibold">
                    <i class="bi bi-person-fill me-2 text-primary"></i>
                    Current Borrowing
                </div>

                <div class="card-body">

                    <?php if($book['borrowings']): ?>

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="fw-semibold">

                                    <?= esc($book['borrowings']['borrower_full_name']) ?>

                                    <?php if($book['borrowings']['user_id'] == session()->get('user_id')): ?>

                                        <span class="badge bg-primary ms-1">
                                            You
                                        </span>

                                    <?php endif; ?>

                                </div>

                                <div class="text-muted small">
                                    <?= esc($book['borrowings']['borrower_library_id']) ?>
                                </div>

                            </div>

                            <span class="badge bg-danger">
                                Borrowed
                            </span>

                        </div>

                    <?php else: ?>

                        <div class="alert alert-success mb-0">

                            <i class="bi bi-check-circle-fill me-2"></i>

                            This book is currently available.

                        </div>

                    <?php endif; ?>

                </div>

            </div>

            <!-- RESERVATION QUEUE -->
            <div class="card border-0 shadow-sm mb-3">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <div class="fw-bold">
                        <i class="bi bi-people-fill text-primary me-2"></i>
                        Reservation Queue
                    </div>

                </div>

                <div class="card-body">

                    <?php if(!empty($book['reservations'])): ?>

                        <?php $queue = 1; ?>

                        <?php foreach($book['reservations'] as $reservation): ?>

                            <div class="<?= $queue !== count($book['reservations']) ? 'border-bottom pb-3 mb-3' : '' ?>">

                                <div class="d-flex align-items-center">

                                    <!-- Queue Number -->
                                    <div class="me-3">

                                        <?php if($queue == 1): ?>

                                            <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center fw-bold"
                                                style="width:42px;height:42px;">

                                                <i class="bi bi-star-fill"></i>

                                            </div>

                                        <?php else: ?>

                                            <div class="rounded-circle bg-light border d-flex align-items-center justify-content-center fw-bold"
                                                style="width:42px;height:42px;">

                                                <?= $queue ?>

                                            </div>

                                        <?php endif; ?>

                                    </div>

                                    <!-- User Info -->
                                    <div class="flex-grow-1">

                                        <div class="fw-semibold">

                                            <?= esc($reservation['reserver_full_name']) ?>

                                            <?php if($reservation['user_id'] == session()->get('user_id')): ?>

                                                <span class="badge bg-primary ms-1">
                                                    You
                                                </span>

                                            <?php endif; ?>

                                        </div>

                                        <div class="small text-muted">
                                            <?= esc($reservation['reserver_library_id']) ?>
                                        </div>

                                    </div>

                                    <!-- Status -->
                                    <div>

                                        <?php if($queue == 1): ?>

                                            <span class="badge bg-success px-3 py-2">
                                                <i class="bi bi-arrow-right-circle-fill me-1"></i>
                                                Next
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-secondary px-3 py-2">
                                                Waiting
                                            </span>

                                        <?php endif; ?>

                                    </div>

                                </div>

                            </div>

                            <?php $queue++; ?>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <div class="text-center py-4">

                            <i class="bi bi-people fs-1 text-muted"></i>

                            <div class="fw-semibold mt-2">
                                No Reservations Yet
                            </div>

                            <div class="text-muted small">
                                Be the first person to reserve this book.
                            </div>

                        </div>

                    <?php endif; ?>

                </div>

            </div>

            <!-- USER ACTIVITY -->
            <?php if($book['has_active_borrow_request'] || $book['user_reservation'] || $book['user_borrowed']): ?>

                <div class="card border-0 shadow-sm mb-3">

                    <div class="card-header bg-white fw-bold">
                        Your Activity
                    </div>

                    <div class="card-body">

                        <?php if($book['user_reservation']): ?>

                            <?php
                                $position = 0;
                                $counter = 1;

                                foreach($book['reservations'] as $r) {

                                    if($r['user_id'] == session()->get('user_id')) {
                                        $position = $counter;
                                        break;
                                    }

                                    $counter++;
                                }
                            ?>

                            <div class="border rounded p-3 mb-3">

                                <div class="fw-bold text-secondary mb-2">
                                    Your Reservation
                                </div>

                                <div class="mb-2">

                                    <span class="badge bg-info text-dark">
                                        Queue Position #<?= $position ?>
                                    </span>

                                </div>

                                <?php if($book['is_first_reserver']): ?>

                                    <?php if(
                                        $book['user_borrow_request'] &&
                                        in_array($book['user_borrow_request']['status'], [
                                            'pending',
                                            'approved',
                                            'rejected'
                                        ])
                                    ): ?>

                                        <div class="text-primary fw-semibold">
                                            <i class="bi bi-hourglass-split me-2"></i> You already sent a borrow request. Waiting for approval.
                                        </div>

                                        <div class="small text-muted mt-1">
                                            Your reservation is being processed.
                                        </div>

                                    <?php else: ?>

                                        <div class="alert alert-success">

                                            <i class="bi bi-check-circle-fill me-2"></i>

                                            It's your turn in the reservation queue.

                                        </div>

                                        <div class="small text-muted">
                                            You can now send a borrow request.
                                        </div>

                                    <?php endif; ?>

                                <?php else: ?>

                                    <div class="small text-muted">
                                        Waiting for your turn in the reservation queue.
                                    </div>

                                <?php endif; ?>

                            </div>

                        <?php endif; ?>
                        
                        <?php if($book['user_borrowing']): ?>

                        <div class="border rounded p-3 mb-3">

                            <div class="fw-bold text-success mb-3">
                                Current Borrowing
                            </div>

                            <div class="mb-3">
                                <div class="small text-muted">
                                    Borrowing Code
                                </div>

                                <span class="badge bg-dark fs-6 px-3 py-2">
                                    <?= esc($book['user_borrowing']['borrowing_code']) ?>
                                </span>
                            </div>

                            <div class="row g-3">

                                <div class="col-md-6">
                                    <div class="small text-muted">
                                        Borrow Date
                                    </div>

                                    <div class="fw-semibold">
                                        <?= date('F d, Y', strtotime($book['user_borrowing']['borrow_date'])) ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="small text-muted">
                                        Due Date
                                    </div>

                                    <div class="fw-semibold">
                                        <?= date('F d, Y', strtotime($book['user_borrowing']['due_date'])) ?>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="small text-muted">
                                        Status
                                    </div>

                                    <?php if(strtotime($book['user_borrowing']['due_date']) < time()): ?>

                                        <span class="badge bg-danger">
                                            Overdue
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-success">
                                            Borrowed
                                        </span>

                                    <?php endif; ?>
                                </div>

                                <?php if($book['user_borrowing']['fine_amount'] > 0): ?>

                                    <div class="col-md-6">
                                        <div class="small text-muted">
                                            Estimated Fine
                                        </div>

                                        <div class="fw-bold text-danger">
                                            ₱<?= number_format($book['user_borrowing']['fine_amount'], 2) ?>
                                        </div>
                                    </div>

                                <?php endif; ?>

                            </div>

                        </div>

                        <?php endif; ?>

                        <?php if(
                            $book['user_borrow_request'] &&
                            in_array($book['user_borrow_request']['status'], [
                                'pending',
                                'approved',
                                'rejected'
                            ])
                        ): ?>

                            <div class="border rounded p-3">

                                <div class="fw-bold text-primary mb-2">
                                    Borrow Request
                                </div>

                                <div class="small text-muted mb-1">
                                    Status
                                </div>

                                <?php if($book['user_borrow_request']['status'] == 'pending'): ?>

                                    <span class="badge bg-warning text-dark mb-2">
                                        Pending
                                    </span>

                                    <div class="small text-muted">
                                        Your borrow request is waiting for librarian approval.
                                    </div>

                                <?php elseif($book['user_borrow_request']['status'] == 'approved'): ?>

                                    <div class="alert alert-success">

                                        <div class="fw-bold mb-2">
                                            Request Approved
                                        </div>

                                        <div class="small text-muted">
                                            Request Code
                                        </div>

                                        <div class="display-6 fw-bold text-dark">
                                            <?= esc($book['user_borrow_request']['borrow_request_code']) ?>
                                        </div>

                                        <hr>

                                        <div class="mb-2">
                                            <strong>Claim Before:</strong><br>
                                            <span class="text-danger fw-bold">
                                                <?= date('F d, Y h:i A', strtotime($book['user_borrow_request']['expires_at'])) ?>
                                            </span>
                                        </div>

                                        <small class="d-block text-muted">
                                            Present this reference number to the librarian when claiming your book.
                                        </small>

                                        <small class="d-block text-danger mt-1">
                                            Failure to claim before the expiration date will automatically cancel this request.
                                        </small>

                                    </div>

                                <?php elseif($book['user_borrow_request']['status'] == 'rejected'): ?>

                                    <span class="badge bg-danger mb-2">
                                        Rejected
                                    </span>

                                    <div class="small text-muted">
                                        Your borrow request was rejected by the librarian.
                                    </div>

                                <?php endif; ?>

                            </div>

                        <?php endif; ?>
                    </div>

                </div>

            <?php endif; ?>

            <!-- ACTIONS -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-semibold">

                    <i class="bi bi-lightning-charge-fill me-2 text-primary"></i>

                    Actions

                </div>

                <div class="card-body">

                    <?php foreach ($buttons as $btn): ?>

                        <?php

                            $icon = 'bi-cursor-fill';

                            if (stripos($btn['text'], 'Borrow') !== false) {
                                $icon = 'bi-book-fill';
                            }

                            if (stripos($btn['text'], 'Reserve') !== false) {
                                $icon = 'bi-bookmark-fill';
                            }

                            if (stripos($btn['text'], 'Cancel') !== false) {
                                $icon = 'bi-x-circle-fill';
                            }

                        ?>

                        <?php if($btn['action'] === '#'): ?>

                            <div class="border rounded p-3 mb-2 bg-light">

                                <div class="d-flex align-items-center">

                                    <i class="bi <?= $icon ?> text-secondary me-3 fs-5"></i>

                                    <div class="flex-grow-1">

                                        <div class="fw-semibold text-muted">
                                            <?= $btn['text'] ?>
                                        </div>

                                        <div class="small text-muted">
                                            Action currently unavailable.
                                        </div>

                                    </div>

                                </div>

                            </div>

                        <?php else: ?>

                            <form action="<?= $btn['action'] ?>"
                                method="post"
                                class="mb-2">

                                <input type="hidden"
                                    name="user_id"
                                    value="<?= session()->get('user_id') ?>">

                                <input type="hidden"
                                    name="book_id"
                                    value="<?= $book['id'] ?>">

                                <button
                                    type="button"
                                    class="btn btn-light border w-100 text-start p-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#actionModal<?= md5($btn['action']) ?>">

                                    <div class="d-flex align-items-center">

                                        <i class="bi <?= $icon ?> text-<?= $btn['color'] ?> me-3 fs-5"></i>

                                        <div class="flex-grow-1">

                                            <div class="fw-semibold text-dark">
                                                <?= $btn['text'] ?>
                                            </div>

                                            <div class="small text-muted">

                                                <?php if(stripos($btn['text'], 'Borrow') !== false): ?>
                                                    Request to borrow this book.
                                                <?php elseif(stripos($btn['text'], 'Reserve') !== false): ?>
                                                    Join the reservation queue.
                                                <?php elseif(stripos($btn['text'], 'Cancel') !== false): ?>
                                                    Remove your current request.
                                                <?php else: ?>
                                                    Continue with this action.
                                                <?php endif; ?>

                                            </div>

                                        </div>

                                        <i class="bi bi-chevron-right text-muted"></i>

                                    </div>

                                </button>

                            </form>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

            </div>

            <?php foreach ($buttons as $btn): ?>

            <div class="modal fade" id="actionModal<?= md5($btn['action']) ?>" tabindex="-1">

                <div class="modal-dialog modal-dialog-centered">

                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title">
                                <?= esc($btn['text']) ?>
                            </h5>

                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <?php if ($btn['type'] === 'borrow_request'): ?>

                                <div class="fw-semibold mb-2">
                                    Borrow Request
                                </div>

                                <div class="small text-muted">
                                    You are about to send a borrow request for this book.
                                    Make sure you understand the borrowing rules.
                                </div>

                            <?php elseif ($btn['type'] === 'cancel_borrow_request'): ?>

                                <div class="text-warning fw-semibold mb-2">
                                    Cancel Borrow Request
                                </div>

                                <div class="small text-muted">
                                    This will cancel your borrow request for this book.
                                </div>

                            <?php elseif ($btn['type'] === 'reservation'): ?>

                                <div class="fw-semibold mb-2">
                                    Reservation
                                </div>

                                <div class="small text-muted">
                                    You will be placed in the reservation queue.
                                </div>

                            <?php elseif ($btn['type'] === 'cancel_reservation'): ?>

                                <div class="text-danger fw-semibold mb-2">
                                    Cancel Reservation
                                </div>

                                <div class="small text-muted">
                                    This will remove you from the reservation queue. You may lose your position.
                                </div>

                            <?php else: ?>

                                <div class="small text-muted">
                                    Are you sure you want to continue?
                                </div>

                            <?php endif; ?>

                        </div>

                        <div class="modal-footer">

                            <button class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <form action="<?= $btn['action'] ?>" method="post">

                                <input type="hidden" name="user_id" value="<?= session()->get('user_id') ?>">
                                <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

                                <button type="submit" class="btn btn-primary">
                                    Confirm
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>