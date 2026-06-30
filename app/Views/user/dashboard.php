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
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm rounded-3">

                <div class="card-header bg-white fw-semibold">
                    Current Borrowings
                </div>

                <div class="card-body p-0">

                    <?php if (!empty($currentBorrowings)): ?>

                        <div class="table-responsive">

                            <table class="table table-hover table-borderless align-middle mb-0">

                                <thead class="table-light">

                                    <tr>
                                        <th class="text-muted">Book</th>
                                        <th class="text-muted">Borrow Date</th>
                                        <th class="text-muted">Due Date</th>
                                        <th class="text-muted">Status</th>
                                    </tr>

                                </thead>

                                <tbody>

                                    <?php foreach ($currentBorrowings as $borrowing): ?>

                                        <tr>

                                            <td class="fw-semibold">
                                                <?= esc($borrowing['title']) ?>
                                            </td>

                                            <td class="text-muted">
                                                <?= date('M d, Y', strtotime($borrowing['borrow_date'])) ?>
                                            </td>

                                            <td class="text-muted">
                                                <?= date('M d, Y', strtotime($borrowing['due_date'])) ?>
                                            </td>

                                            <td>

                                                <?php if (strtotime($borrowing['due_date']) < time()): ?>

                                                    <span class="badge bg-danger px-3 py-2">
                                                        Overdue
                                                    </span>

                                                <?php else: ?>

                                                    <span class="badge bg-secondary px-3 py-2">
                                                        Active
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
                            No active borrowings found.
                        </div>

                    <?php endif; ?>

                </div>

            </div>

        </div>

        <!-- RIGHT: QUICK ACCESS -->
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm rounded-3 mb-3">

                <div class="card-header bg-white fw-semibold">
                    Quick Access
                </div>

                <div class="list-group list-group-flush">

                    <a href="<?= site_url('user/books') ?>" class="list-group-item list-group-item-action">
                        Browse Books
                    </a>

                    <a href="<?= site_url('user/my_transactions/borrowings') ?>" class="list-group-item list-group-item-action">
                        My Transactions
                    </a>

                    <a href="<?= site_url('user/overdue/list') ?>" class="list-group-item list-group-item-action">
                        Overdue Books
                    </a>

                    <a href="<?= site_url('user/fines/unpaid') ?>" class="list-group-item list-group-item-action">
                        Fines
                    </a>

                    <a href="<?= site_url('user/profile') ?>" class="list-group-item list-group-item-action">
                        Profile
                    </a>

                    <a href="<?= site_url('user/help') ?>" class="list-group-item list-group-item-action">
                        Help / FAQ
                    </a>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>