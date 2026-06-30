<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
User | Profile
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Profile
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid py-3">

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

    <div class="row g-4">

        <!-- PROFILE INFO -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-semibold">
                    Profile Information
                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="text-muted small">Full Name</div>
                            <div class="fw-semibold">
                                <?= esc($user['full_name'] ?? '-') ?>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">Email Address</div>
                            <div class="fw-semibold">
                                <?= esc($user['email'] ?? '-') ?>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">Library ID</div>
                            <div class="fw-semibold">
                                <?= esc($user['library_id'] ?? '-') ?>
                            </div>

                        </div>
                        
                        <div class="col-md-6">

                            <div class="text-muted small">Contact Number</div>
                            <div class="fw-semibold">
                                <?= esc($user['contact_number'] ?? '-') ?>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small">Member Since</div>
                            <div class="fw-semibold">
                                <?= !empty($user['created_at'])
                                    ? date('M d, Y', strtotime($user['created_at']))
                                    : '-' ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- ACTIONS ONLY -->
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-semibold">
                    Account Settings
                </div>

                <div class="card-body">

                    <button class="btn btn-outline-primary w-100 mb-2"
                            data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                        Change Password
                    </button>

                    <div class="text-muted small">
                        Keep your account secure by updating your password regularly.
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- CHANGE PASSWORD MODAL -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header bg-white">
                <h5 class="modal-title fw-semibold">Change Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form method="post" action="<?= site_url('user/profile/change_password') ?>">

                <div class="modal-body">

                    <!-- CURRENT PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label">Current Password</label>
                        <input type="password"
                               name="current_password"
                               class="form-control"
                               required>
                    </div>

                    <!-- NEW PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label">New Password</label>
                        <input type="password"
                               name="new_password"
                               class="form-control"
                               required>
                    </div>

                    <!-- CONFIRM PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label">Confirm New Password</label>
                        <input type="password"
                               name="confirm_password"
                               class="form-control"
                               required>
                    </div>

                    <div class="text-muted small">
                        Make sure your password is strong and secure.
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        Update Password
                    </button>
                </div>

            </form>

        </div>

    </div>
</div>
<?= $this->endSection() ?>