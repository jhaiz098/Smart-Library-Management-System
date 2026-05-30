<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Profile
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Profile
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <div class="row g-3">

        <!-- ACCOUNT DETAILS -->
        <div class="col-lg-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-bold">
                    Account Information
                </div>

                <div class="card-body">

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Full Name
                            </label>

                            <div class="fw-semibold">
                                <?= esc($user['full_name'] ?? '-') ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Email Address
                            </label>

                            <div class="fw-semibold">
                                <?= esc($user['email'] ?? '-') ?>
                            </div>
                        </div>

                    </div>

                    <div class="row mb-3">

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Library ID
                            </label>

                            <div class="fw-semibold">
                                <?= esc($user['library_id'] ?? '-') ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Account Status
                            </label>

                            <div>
                                <span class="badge bg-success">
                                    Active
                                </span>
                            </div>
                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-6">
                            <label class="text-muted small">
                                Member Since
                            </label>

                            <div class="fw-semibold">
                                <?= !empty($user['created_at']) ? date('M d, Y', strtotime($user['created_at'])) : '-' ?>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- LIBRARY SUMMARY -->
        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-bold">
                    Library Summary
                </div>

                <div class="card-body">

                    <div class="row text-center">

                        <div class="col-md-3">
                            <h4 class="mb-1">
                                <?= $totalBorrowed ?? 0 ?>
                            </h4>

                            <div class="text-muted small">
                                Books Borrowed
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h4 class="mb-1">
                                <?= $activeBorrowings ?? 0 ?>
                            </h4>

                            <div class="text-muted small">
                                Currently Borrowed
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h4 class="mb-1">
                                <?= $pendingReservations ?? 0 ?>
                            </h4>

                            <div class="text-muted small">
                                Active Reservations
                            </div>
                        </div>

                        <div class="col-md-3">
                            <h4 class="mb-1">
                                ₱<?= number_format($unpaidFines ?? 0, 2) ?>
                            </h4>

                            <div class="text-muted small">
                                Unpaid Fines
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ACTIONS -->
        <div class="col-12">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-bold">
                    Account Actions
                </div>

                <div class="card-body">

                    <a href="<?= site_url('user/profile/change-password') ?>"
                        class="btn btn-outline-primary">

                        Change Password

                    </a>

                </div>

            </div>

        </div>

    </div>
</div>

<?= $this->endSection() ?>