<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Reservations
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Reservations
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="p-3">
    <div class="card border-0 shadow-sm">
        <!-- HEADER -->
        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        Book Reservations
                    </h5>

                    <div class="text-muted small">
                        Track reservation queues, claims, and reservation status
                    </div>

                </div>

            </div>

        </div>

        <!-- BODY -->
        <div class="card-body">
            <ul class="nav nav-pills gap-2 mb-3">

                <li class="nav-item">
                    <a href="?type=all"
                    class="nav-link <?= ($type ?? 'all') == 'all' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-people-fill me-1"></i>
                        All Users

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=user"
                    class="nav-link <?= ($type ?? '') == 'user' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-person-fill me-1"></i>
                        Users

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=staff"
                    class="nav-link <?= ($type ?? '') == 'staff' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-person-badge-fill me-1"></i>
                        Staff

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=admin"
                    class="nav-link <?= ($type ?? '') == 'admin' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-shield-lock-fill me-1"></i>
                        Admin

                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<?= $this->endSection() ?>