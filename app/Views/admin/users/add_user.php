<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
Add User
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Add User
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <!-- HEADER -->
                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <div>
                        <div class="fw-bold fs-5">Create New User</div>
                        <div class="text-muted small">
                            Fill in the information below to add a new account
                        </div>
                    </div>

                    <a href="/admin/users" class="btn btn-outline-secondary btn-sm">
                        Back
                    </a>

                </div>

                <!-- BODY -->
                <div class="card-body">

                    <?php if(session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger border-0">
                            <ul class="mb-0">
                                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                                    <li><?= esc($error) ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    <?php endif; ?>

                    <form action="/admin/users/add" method="post">

                        <?= csrf_field() ?>

                        <div class="row g-3">

                            <!-- FULL NAME -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Full Name</label>
                                <input type="text" name="full_name"
                                       class="form-control"
                                       placeholder="Enter full name"
                                       value="<?= old('full_name') ?>">
                            </div>

                            <!-- EMAIL -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Email</label>
                                <input type="email" name="email"
                                       class="form-control"
                                       placeholder="Enter email"
                                       value="<?= old('email') ?>">
                            </div>

                            <!-- CONTACT -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Contact Number</label>
                                <input type="text" name="contact_number"
                                       class="form-control"
                                       placeholder="09XXXXXXXXX"
                                       value="<?= old('contact_number') ?>">
                            </div>

                            <!-- ROLE -->
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Role</label>
                                <select name="role_id" id="roleSelect" class="form-select" required>
                                    <option value="">Select Role</option>

                                    <?php foreach($roles as $role): ?>
                                        <?php if($role['id'] != 1): ?> <!-- ❌ hide Admin -->
                                            <option value="<?= $role['id'] ?>">
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
                                        <option value="<?= $level['id'] ?>">
                                            <?= esc($level['name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                        </div>

                        <hr>

                        <!-- ACTIONS -->
                        <div class="d-flex justify-content-end gap-2">

                            <a href="/admin/users" class="btn btn-light border">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                Save User
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<style>
.card {
    border-radius: 12px;
}

.card-header {
    border-bottom: 1px solid #eee;
}

.form-control, .form-select {
    border-radius: 8px;
}

.btn {
    border-radius: 8px;
}
</style>

<script>
document.getElementById('roleSelect').addEventListener('change', function () {
    let staffBox = document.getElementById('staffPositionBox');

    if (this.value == 2) {
        staffBox.classList.remove('d-none');
    } else {
        staffBox.classList.add('d-none');
    }
});
</script>

<?= $this->endSection() ?>