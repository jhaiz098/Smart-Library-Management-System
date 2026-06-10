<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Borrowed Books
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Borrowed Books
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
                Borrowings Records
            </div>

            <ul class="nav nav-pills gap-2">

                <li class="nav-item">

                    <a href="borrowed"
                       class="nav-link <?= ($borrow_status == 'borrowed') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-journal-arrow-up me-1"></i>
                        Borrowed

                    </a>

                </li>

                <li class="nav-item">

                    <a href="returned"
                       class="nav-link <?= ($borrow_status == 'returned') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-journal-check me-1"></i>
                        Returned

                    </a>

                </li>

                <li class="nav-item">

                    <a href="all"
                       class="nav-link <?= ($borrow_status == 'all') ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-collection me-1"></i>
                        All

                    </a>

                </li>

            </ul>

        </div>

        <div class="card-body">

            <?= $this->renderSection('render_borrows') ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>