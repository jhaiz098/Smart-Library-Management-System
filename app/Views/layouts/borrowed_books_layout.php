<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('header') ?>
    Borrowed Books
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">
    <div class="card">
        <div class="card-header fw-bold">
            Borrowed Books
        </div>

        <div class="card-body">

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
                        <li class="nav-item"><a href="borrowed" class="nav-link <?= ($borrow_status) == "borrowed" ? 'active' : '' ?>">Borrowed</a></li>
                        <li class="nav-item"><a href="returned" class="nav-link <?= ($borrow_status) == "returned" ? 'active' : '' ?>">Returned</a></li>
                    </ul>
                    <?= $this->renderSection('render_borrowed') ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>