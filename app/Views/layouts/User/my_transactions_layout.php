<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | My Transactions
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    My Transactions
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid py-3">

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white">

            <div class="fw-semibold mb-2">
                Transaction Records
            </div>

            <ul class="nav nav-pills gap-2">

                <li class="nav-item">
                    <a href="borrowings"
                       class="nav-link <?= ($transaction_type == 'borrowings') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-journal-bookmark-fill me-1"></i>
                        Borrowings

                    </a>
                </li>

                <li class="nav-item">
                    <a href="borrow_requests"
                       class="nav-link <?= ($transaction_type == 'borrow_requests') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-send-fill me-1"></i>
                        Requests

                    </a>
                </li>

                <li class="nav-item">
                    <a href="reservations"
                       class="nav-link <?= ($transaction_type == 'reservations') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-bookmark-check-fill me-1"></i>
                        Reservations

                    </a>
                </li>

                <li class="nav-item">
                    <a href="all"
                       class="nav-link <?= ($transaction_type == 'all') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-clock-history me-1"></i>
                        All

                    </a>
                </li>

            </ul>

        </div>

        <div class="card-body">

            <?= $this->renderSection('render_transactions') ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>