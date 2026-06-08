<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
User | Dashboard
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-0 px-3">

    <!-- HERO HEADER -->
    <div class="card border-0 shadow-sm mb-4 bg-light rounded-3">

        <div class="card-body p-4">

            <div class="d-flex justify-content-between align-items-center flex-wrap">

                <div>

                    <div class="text-uppercase small text-secondary mb-1">
                        Library Management System
                    </div>

                    <h3 class="fw-bold mb-1">
                        Welcome back, <?= esc(session()->get('full_name')) ?>
                    </h3>

                    <div class="text-muted">
                        Track your borrowings, reservations, overdue books, and fines in real time.
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- STATS -->
    <div class="row g-3 mb-4">

        <div class="col-6 col-lg-2">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Total
                    </div>

                    <h3 class="fw-bold mb-0 text-dark">
                        <?= $totalBorrowings ?? 0 ?>
                    </h3>

                    <div class="text-muted small">
                        Borrowings
                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-lg-2">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Active
                    </div>

                    <h3 class="fw-bold mb-0 text-primary">
                        <?= $activeBorrowings ?? 0 ?>
                    </h3>

                    <div class="text-muted small">
                        Borrowed
                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-lg-2">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Reservations
                    </div>

                    <h3 class="fw-bold mb-0 text-warning">
                        <?= $reservedBooks ?? 0 ?>
                    </h3>

                    <div class="text-muted small">
                        In Queue
                    </div>

                </div>

            </div>

        </div>

        <div class="col-6 col-lg-2">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Overdue
                    </div>

                    <h3 class="fw-bold mb-0 text-danger">
                        <?= $overdueBooks ?? 0 ?>
                    </h3>

                    <div class="text-muted small">
                        Books
                    </div>

                </div>

            </div>

        </div>

        <div class="col-12 col-lg-4">

            <div class="card border-0 shadow-sm h-100 rounded-3">

                <div class="card-body">

                    <div class="text-uppercase text-muted small mb-2">
                        Outstanding Fine
                    </div>

                    <h3 class="fw-bold mb-0 text-success">
                        ₱<?= number_format($unpaidFines ?? 0, 2) ?>
                    </h3>

                    <div class="text-muted small">
                        Unpaid balance
                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- MAIN CONTENT -->
    <div class="row g-4">

        <!-- LEFT: BORROWINGS -->
        <div class="col-lg-12">

            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-header bg-white fw-semibold">
                    Current Borrowings
                </div>

                <div class="card-body p-0">


                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0 fs-7">

                                <thead class="table-light text-uppercase">

                                    <tr>
                                        <th>#</th>
                                        <th>Book</th>
                                        <th>Borrow Date</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                    </tr>

                                </thead>

                                <tbody>
                                    <?php if (!empty($currentBorrowings)): ?>
                                        <?php $i=1; foreach ($currentBorrowings as $borrowing): ?>

                                            <tr>

                                                <td><?= $i++ ?></td>

                                                <td>
                                                    <div>
                                                        <?= esc($borrowing['title']) ?>
                                                    </div>

                                                    <div class="small text-muted">

                                                        <?php
                                                            $description = strip_tags($borrowing['description']);
                                                            echo strlen($description) > 60
                                                                ? substr($description, 0, 60) . '...'
                                                                : $description;
                                                        ?>

                                                    </div>
                                                </td>

                                                <td>
                                                    <?= date('M d, Y', strtotime($borrowing['borrow_date'])) ?>
                                                </td>

                                                <td>
                                                    <?= date('M d, Y', strtotime($borrowing['due_date'])) ?>
                                                </td>

                                                <td>

                                                    <?php if (strtotime($borrowing['due_date']) < time()): ?>

                                                        <span class="badge rounded-pill bg-danger px-3 py-2">
                                                            Overdue
                                                        </span>

                                                    <?php else: ?>

                                                        <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                            Active
                                                        </span>

                                                    <?php endif; ?>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="5" class="text-center text-muted py-4">No active borrowings found.</td>
                                        </tr>
                                    <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                    

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>