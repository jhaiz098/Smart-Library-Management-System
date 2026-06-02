<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Edit User
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Edit User
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <div>
                        <div class="fw-bold fs-5">
                            Edit User
                        </div>

                        <div class="text-muted small">
                            Update user information
                        </div>
                    </div>

                    <a href="/admin/users" class="btn btn-outline-secondary btn-sm">
                        Back
                    </a>

                </div>

                <div class="card-body">

                    <?php if(session()->getFlashdata('errors')): ?>

                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                    <?php endif; ?>

                    <form action="/admin/users/update/<?= $user['id'] ?>" method="post">

                        <?= csrf_field() ?>

                        <div class="row g-3">

                            <!-- Library ID -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Library ID
                                </label>

                                <div class="form-control bg-light-subtle border">
                                    <span class="fw-semibold">
                                        <?= esc($user['library_id']) ?>
                                    </span>
                                </div>

                                <div class="small text-muted mt-1">
                                    Library IDs cannot be changed.
                                </div>

                            </div>

                            <!-- Account Type -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Account Type
                                </label>

                                <div class="form-control bg-light-subtle border fw-semibold">

                                    <?php if($user['role_id'] == 1): ?>

                                        Admin

                                    <?php elseif($user['role_id'] == 2): ?>

                                        Staff

                                    <?php else: ?>

                                        User

                                    <?php endif; ?>

                                </div>

                                <div class="small text-muted mt-1">
                                    Account type is managed separately.
                                </div>

                            </div>

                            <!-- Full Name -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Full Name
                                </label>

                                <input
                                    type="text"
                                    name="full_name"
                                    class="form-control"
                                    value="<?= old('full_name', $user['full_name']) ?>"
                                    required
                                >

                            </div>

                            <!-- Email -->
                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Email Address
                                </label>

                                <input
                                    type="email"
                                    name="email"
                                    class="form-control"
                                    value="<?= old('email', $user['email']) ?>"
                                    required
                                >

                            </div>

                            <!-- Contact Number -->
                            <div class="col-md-12">

                                <label class="form-label fw-semibold">
                                    Contact Number
                                </label>

                                <input
                                    type="text"
                                    name="contact_number"
                                    class="form-control"
                                    value="<?= old('contact_number', $user['contact_number']) ?>"
                                >

                            </div>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="/admin/users"
                                class="btn btn-light border"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Save Changes
                            </button>

                        </div>

                    </form>

                    <hr class="my-4">

                    <div class="card border-warning">

                        <div class="card-header bg-warning-subtle">

                            <div class="fw-semibold text-warning-emphasis">
                                Password Management
                            </div>

                        </div>

                        <div class="card-body">

                            <p class="text-muted mb-3">
                                Reset this user's password. The user will need to use the new password on their next login.
                            </p>

                            <form action="/admin/users/reset_password/<?= $user['id'] ?>" method="post">

                                <?= csrf_field() ?>

                                <div class="row g-3">

                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            New Password
                                        </label>

                                        <input
                                            type="password"
                                            name="password"
                                            class="form-control"
                                            required
                                        >

                                    </div>

                                    <div class="col-md-6">

                                        <label class="form-label fw-semibold">
                                            Confirm Password
                                        </label>

                                        <input
                                            type="password"
                                            name="password_confirm"
                                            class="form-control"
                                            required
                                        >

                                    </div>

                                </div>

                                <div class="mt-3">

                                    <button
                                        type="submit"
                                        class="btn btn-warning"
                                        onclick="return confirm('Reset this user\\'s password?')"
                                    >
                                        Reset Password
                                    </button>

                                </div>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>