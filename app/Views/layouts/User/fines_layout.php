<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Fines
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Fines
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="p-3">
    <div class="card">
        <div class="card-header fw-bold">Fines</div>
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
                                <li class="nav-item"><a href="unpaid" class="nav-link <?= ($fine_status) == "unpaid" ? 'active' : '' ?>">Unpaid</a></li>
                                <li class="nav-item"><a href="paid" class="nav-link <?= ($fine_status) == "paid" ? 'active' : '' ?>">Paid</a></li>
                                <li class="nav-item"><a href="all" class="nav-link <?= ($fine_status) == "all" ? 'active' : '' ?>">All</a></li>
                            </ul>
                            <?= $this->renderSection('render_fines') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>