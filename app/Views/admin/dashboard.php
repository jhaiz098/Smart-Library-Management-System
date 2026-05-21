<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Dashboard
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Dashboard Overview
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="p-3">
    <!-- WELCOME -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">

            <h3 class="fw-bold mb-1">
                Welcome back,
                <?= session()->get('full_name') ?>
            </h3>

            <p class="text-muted mb-0">
                Smart Library Management System Overview
            </p>

        </div>
    </div>

    <!-- STATISTICS -->
    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small">
                        Total Books
                    </div>

                    <h2 class="fw-bold">
                        <?= $totalBooks ?>
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small">
                        Active Borrowings
                    </div>

                    <h2 class="fw-bold text-primary">
                        <?= $activeBorrowed ?>
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small">
                        Overdue Books
                    </div>

                    <h2 class="fw-bold text-danger">
                        <?= $overdueBorrowed ?>
                    </h2>

                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">

                    <div class="text-muted small">
                        Unpaid Fines
                    </div>

                    <h2 class="fw-bold text-warning">
                        <?= $totalFines ?>
                    </h2>

                </div>
            </div>
        </div>

    </div>

    <!-- SECOND ROW -->
    <div class="row g-4">

        <!-- RECENT BORROWINGS -->
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold">
                        Recent Borrowings
                    </h5>
                </div>

                <div class="card-body p-0">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr>
                                <th>Borrower</th>
                                <th>Book</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php foreach($recentBorrowings as $b): ?>

                                <tr>

                                    <td>
                                        <?= $b['full_name'] ?>
                                    </td>

                                    <td>
                                        <?= $b['title'] ?>
                                    </td>

                                    <td>

                                        <?php if($b['status'] === 'borrowed'): ?>

                                            <span class="badge bg-primary">
                                                Borrowed
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-success">
                                                Returned
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

        <!-- ALERTS -->
        <div class="col-lg-5">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white border-0">
                    <h5 class="mb-0 fw-bold text-danger">
                        Overdue Alerts
                    </h5>
                </div>

                <div class="card-body">

                    <?php if(empty($overdueList)): ?>

                        <div class="text-muted">
                            No overdue books.
                        </div>

                    <?php else: ?>

                        <?php foreach($overdueList as $o): ?>

                            <div class="border rounded p-2 mb-2">

                                <strong>
                                    <?= $o['full_name'] ?>
                                </strong>

                                <div class="small text-muted">
                                    <?= $o['title'] ?>
                                </div>

                            </div>

                        <?php endforeach; ?>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>
</div>
<?= $this->endSection() ?>