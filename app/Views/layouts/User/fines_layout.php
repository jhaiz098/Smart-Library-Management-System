<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Fines
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Fines
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
                Fine Records
            </div>

            <ul class="nav nav-pills gap-2">

                <li class="nav-item">

                    <a href="unpaid"
                       class="nav-link <?= ($fine_status == 'unpaid') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-exclamation-circle-fill me-1"></i>
                        Unpaid

                    </a>

                </li>

                <li class="nav-item">

                    <a href="paid"
                       class="nav-link <?= ($fine_status == 'paid') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-check-circle-fill me-1"></i>
                        Paid

                    </a>

                </li>

                <li class="nav-item">

                    <a href="all"
                       class="nav-link <?= ($fine_status == 'all') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-receipt-cutoff me-1"></i>
                        All

                    </a>

                </li>

            </ul>

        </div>

        <div class="card-body">

            <?= $this->renderSection('render_fines') ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>