<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('header') ?>
    Borrow Requests
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
                                <li class="nav-item"><a href="pending_borrow_requests" class="nav-link <?= ($request_status) == "pending" ? 'active' : '' ?>">Pending</a></li>
                                <li class="nav-item"><a href="approved_borrow_requests" class="nav-link <?= ($request_status) == "approved" ? 'active' : '' ?>">Approved</a></li>
                                <li class="nav-item"><a href="completed_borrow_requests" class="nav-link <?= ($request_status) == "completed" ? 'active' : '' ?>">Completed</a></li>
                            </ul>
                            <?= $this->renderSection('render_requests') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>