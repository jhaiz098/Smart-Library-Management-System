<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | My Transactions
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    My Transactions
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="p-3">
    <div class="card">
        <div class="card-header fw-bold">Borrow Requests</div>
        <div class="card-body">
            
            <div class="row">
                <div class="col-12">
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

                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-tabs mb-3">
                                <li class="nav-item"><a href="borrowings" class="nav-link <?= ($transaction_type) == "borrowings" ? 'active' : '' ?>">Borrowings</a></li>
                                <li class="nav-item"><a href="borrow_requests" class="nav-link <?= ($transaction_type) == "borrow_requests" ? 'active' : '' ?>">Borrow Requests</a></li>
                                <li class="nav-item"><a href="reservations" class="nav-link <?= ($transaction_type) == "reservations" ? 'active' : '' ?>">Reservations</a></li>
                                <li class="nav-item"><a href="all" class="nav-link <?= ($transaction_type) == "all" ? 'active' : '' ?>">All</a></li>
                            </ul>
                            <?= $this->renderSection('render_transactions') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>