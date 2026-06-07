<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Dashboard Overview
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-3 px-3">

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

    <!-- HERO -->
    <div class="card border-0 shadow-sm mb-4 bg-light rounded-3">

        <div class="card-body p-4">

            <div>

                <div class="text-uppercase small text-secondary mb-1">
                    Smart Library Management System
                </div>

                <h3 class="fw-bold mb-1">
                    Welcome back, <?= esc(session()->get('full_name')) ?>
                </h3>

                <div class="text-muted">
                    Monitor books, borrowings, requests, overdue items, and fines across the library.
                </div>

            </div>

        </div>

    </div>

    <!-- STATISTICS -->
    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-3">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Books
                    </div>

                    <h3 class="fw-bold mb-0">
                        <?= $totalBooks ?>
                    </h3>

                    <div class="text-muted small">
                        Total Collection
                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-lg-3">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Borrowed
                    </div>

                    <h3 class="fw-bold mb-0 text-primary">
                        <?= $activeBorrowed ?>
                    </h3>

                    <div class="text-muted small">
                        Active Loans
                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-lg-3">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Overdue
                    </div>

                    <h3 class="fw-bold mb-0 text-danger">
                        <?= $overdueBorrowed ?>
                    </h3>

                    <div class="text-muted small">
                        Books
                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-lg-3">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Unpaid Fines
                    </div>

                    <h3 class="fw-bold mb-0 text-warning">
                        <?= $totalFines ?>
                    </h3>

                    <div class="text-muted small">
                        Outstanding
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- MAIN CONTENT -->
    <div class="row g-4">

        <!-- RECENT BORROWINGS -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-header bg-white fw-semibold">

                    <div class="d-flex justify-content-between align-items-center">

                        <span>
                            Recent Borrowings
                        </span>

                    </div>

                </div>

                <div class="card-body p-0">

                    <?php if(!empty($recentBorrowings)): ?>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th>#</th>
                                        <th>Borrower Code</th>
                                        <th>Borrower</th>
                                        <th>Book</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php $i = 1; foreach($recentBorrowings as $b): ?>

                                        <tr>

                                            <td>
                                                <?= $i++ ?>
                                            </td>

                                            <td>
                                                <span class="badge bg-dark rounded-pill px-3 py-2">
                                                    <?= $b['borrowing_code'] ?>
                                                </span>
                                            </td>

                                            <td>

                                                <div class="fw-semibold">
                                                    <?= esc($b['full_name']) ?>
                                                </div>

                                            </td>

                                            <td>
                                                <?= esc($b['title']) ?>
                                            </td>

                                            <td>

                                                <?php if($b['status'] === 'borrowed'): ?>

                                                    <span class="badge bg-primary rounded-pill px-3 py-2">
                                                        Borrowed
                                                    </span>

                                                <?php else: ?>

                                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                                        Returned
                                                    </span>

                                                <?php endif; ?>

                                            </td>

                                        </tr>

                                    <?php endforeach; ?>

                                </tbody>

                            </table>

                        </div>

                    <?php else: ?>

                        <div class="text-center p-4 text-muted">
                            No borrowing records found.
                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

        <!-- RIGHT SIDE -->
        <div class="col-lg-4">

            <!-- OVERDUE ALERTS -->
            <div class="card border-0 shadow-sm rounded-3 mb-3">

                <div class="card-header bg-white fw-semibold">

                    <div class="d-flex justify-content-between align-items-center">

                        <span class="text-danger">
                            Overdue Alerts
                        </span>

                    </div>

                </div>

                <div class="card-body">

                    <?php if(empty($overdueList)): ?>

                        <div class="text-center py-4">

                            <i class="bi bi-check-circle text-success fs-1"></i>

                            <div class="mt-2 text-muted">
                                No overdue books.
                            </div>

                        </div>

                    <?php else: ?>

                        <?php foreach($overdueList as $o): ?>

                            <div class="border rounded p-3 mb-2">

                                <div class="fw-semibold">
                                    <?= esc($o['full_name']) ?>
                                </div>

                                <div class="small text-muted">
                                    <?= esc($o['title']) ?>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </div>

            <!-- QUICK ACCESS -->
            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-header bg-white fw-semibold">
                    Quick Access
                </div>

                <div class="list-group list-group-flush">
                    
                    <a href="<?= site_url('admin/users') ?>" class="list-group-item list-group-item-action">
                        User Management
                    </a>

                    <a href="<?= site_url('admin/book_management_active') ?>" class="list-group-item list-group-item-action">
                        Book Management
                    </a>

                    <a href="<?= site_url('admin/borrowed_books') ?>" class="list-group-item list-group-item-action">
                        Borrowed Books
                    </a>

                    <a href="<?= site_url('admin/borrow_requests') ?>" class="list-group-item list-group-item-action">
                        Borrow Requests
                    </a>

                    <a href="<?= site_url('admin/reservations') ?>" class="list-group-item list-group-item-action">
                        Reservations
                    </a>

                    <a href="<?= site_url('admin/fines') ?>" class="list-group-item list-group-item-action">
                        Fines
                    </a>

                    <a href="<?= site_url('admin/library_settings') ?>" class="list-group-item list-group-item-action">
                        Settings
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>