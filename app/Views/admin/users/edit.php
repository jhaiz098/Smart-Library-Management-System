<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Edit User
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Edit User
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

<a href="/admin/users" class="btn btn-secondary mb-3">
    Back
</a>

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
                            <div class="col-md-6">

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

                            <!-- ROLE -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role</label>
                                <select name="role_id" id="roleSelect" class="form-select" required>
                                    <option value="">Select Role</option>

                                    <?php foreach($roles as $role): ?>
                                        <?php if($role['id'] != 1): ?> <!-- ❌ hide Admin -->
                                            <option value="<?= $role['id'] ?>" <?= $user['role_id'] == $role['id'] ? 'selected' : '' ?>>
                                                <?= ucfirst($role['name']) ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>

                                </select>
                            </div>

                            <!-- STAFF POSITION (hidden by default) -->
                            <div class="col-md-6 d-none" id="staffPositionBox">
                                <label class="form-label fw-semibold">Staff Position</label>
                                <select name="staff_level_id" class="form-select">
                                    <option value="">Select Position</option>
                                    <?php foreach($staff_levels as $level): ?>
                                        <option value="<?= $level['id'] ?>" <?= $user['staff_level_id'] == $level['id'] ? 'selected' : '' ?>>
                                            <?= esc($level['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
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

                </div>

            </div>

        </div>

    </div>

</div>

<script>
function toggleStaffPosition() {

    let roleSelect = document.getElementById('roleSelect');
    let staffBox = document.getElementById('staffPositionBox');

    if (roleSelect.value == 2) {
        staffBox.classList.remove('d-none');
    } else {
        staffBox.classList.add('d-none');
    }
}

toggleStaffPosition();

document
    .getElementById('roleSelect')
    .addEventListener('change', toggleStaffPosition);
</script>

<?= $this->endSection() ?>