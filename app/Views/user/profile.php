<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
User | Profile
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Profile
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid py-0">

    <!-- FLASH MESSAGES -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-exclamation-circle-fill"></i>
            <div><?= session()->getFlashdata('error') ?></div>
        </div>
    <?php endif; ?>

    <div class="row g-4">

        <!-- PROFILE INFORMATION -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white">

                    <div class="d-flex align-items-center gap-3">

                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                             style="width:60px;height:60px;font-size:24px;">

                            <?= strtoupper(substr($user['full_name'] ?? 'U', 0, 1)) ?>

                        </div>

                        <div>

                            <h5 class="mb-1 fw-bold">
                                <?= esc($user['full_name'] ?? '-') ?>
                            </h5>

                            <div class="text-muted small">
                                Library User
                            </div>

                        </div>

                    </div>

                </div>

                <div class="card-body">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <div class="text-muted small mb-1">
                                Email Address
                            </div>

                            <div class="fw-semibold">
                                <i class="bi bi-envelope me-2 text-primary"></i>
                                <?= esc($user['email'] ?? '-') ?>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small mb-1">
                                Library ID
                            </div>

                            <div class="fw-semibold">
                                <i class="bi bi-person-badge me-2 text-primary"></i>
                                <?= esc($user['library_id'] ?? '-') ?>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small mb-1">
                                Contact Number
                            </div>

                            <div class="fw-semibold">
                                <i class="bi bi-telephone me-2 text-primary"></i>
                                <?= esc($user['contact_number'] ?? '-') ?>
                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="text-muted small mb-1">
                                Member Since
                            </div>

                            <div class="fw-semibold">
                                <i class="bi bi-calendar-event me-2 text-primary"></i>

                                <?= !empty($user['created_at'])
                                    ? date('M d, Y', strtotime($user['created_at']))
                                    : '-' ?>
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

        <!-- SETTINGS -->
        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-semibold">
                    Account Settings
                </div>

                <div class="card-body">

                    <div class="border rounded p-3">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="fw-semibold">
                                    Password Security
                                </div>

                                <div class="text-muted small">
                                    Update your password regularly to keep your account secure.
                                </div>

                            </div>

                            <button class="btn btn-primary"
                                    data-bs-toggle="modal"
                                    data-bs-target="#changePasswordModal">

                                <i class="bi bi-shield-lock me-1"></i>
                                Change

                            </button>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<!-- CHANGE PASSWORD MODAL -->
<div class="modal fade" id="changePasswordModal" tabindex="-1">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">
                    Change Password
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <form method="post"
                  action="<?= site_url('user/profile/change_password') ?>">

                <div class="modal-body">

                    <div class="mb-3">

                        <label class="form-label">
                            Current Password
                        </label>

                        <input type="password"
                               name="current_password"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            New Password
                        </label>

                        <input type="password"
                               name="new_password"
                               class="form-control"
                               required>

                    </div>

                    <div class="mb-3">

                        <label class="form-label">
                            Confirm New Password
                        </label>

                        <input type="password"
                               name="confirm_password"
                               class="form-control"
                               required>

                    </div>

                    <div class="small text-muted">
                        Use a strong password containing letters, numbers, and symbols.
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