<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Setting
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Settings
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">
    <div class="card border-0 shadow-sm">
        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">

            <div>

                <h5 class="fw-bold mb-1">
                    Roles & Permissions
                </h5>

                <div class="text-muted small">
                    Manage system roles, access levels, and permissions for users and staff
                </div>

            </div>

        </div>

        <div class="card-body">
            <?= view('partials/admin/settings_nav') ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success mt-3">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger mt-3">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="card mt-3">

                <div class="card-body">

                    <!-- ROLE CREATION -->
                    <div class="card mb-3 border-0 shadow-sm">

                        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">

                            <div>

                                <h6 class="fw-bold mb-1">
                                    Roles Management
                                </h6>

                                <div class="text-muted small">
                                    Create and manage system roles for staff and users
                                </div>

                            </div>

                            <button
                                class="btn btn-primary btn-sm"
                                data-bs-toggle="modal"
                                data-bs-target="#createRoleModal">

                                <i class="bi bi-plus-circle me-1"></i>
                                Add Role

                            </button>

                        </div>

                    </div>
                    
                    <div class="table-responsive">

                        <table class="table table-bordered table-hover align-middle">

                            <thead class="table-light text-center text-uppercase">
                                <tr">
                                    <th width="25%">Role</th>

                                    <?php
                                    $permission_keys = [
                                        'can_manage_users' => 'Manage Users',
                                        'can_manage_books' => 'Manage Books',
                                        'can_manage_borrowed_books' => 'Borrow Books',
                                        'can_manage_borrow_requests' => 'Borrowed Requests',
                                        'can_manage_returns' => 'Process Returns',
                                        'can_manage_fines' => 'Manage Fines',
                                        'can_manage_settings' => 'System Settings',
                                        'can_manage_categories' => 'Manage Categories',
                                        'can_manage_roles_permissions' => 'Roles & Permissions'
                                    ];
                                    ?>

                                    <?php foreach($permission_keys as $key => $label): ?>
                                        <th><?= esc($label) ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>

                            <tbody>

                                <?php foreach($permissions as $perm): ?>

                                    <tr>

                                        <!-- ROLE -->
                                        <td class="fw-semibold">
                                            <?= esc($perm['label']) ?>
                                        </td>

                                        <!-- PERMISSIONS -->
                                        <?php foreach($permission_keys as $key => $label): ?>

                                            <td class="text-center">

                                                <input type="checkbox"
                                                    class="form-check-input permission-toggle"
                                                    data-id="<?= $perm['id'] ?>"
                                                    data-key="<?= $key ?>"
                                                    <?= $perm[$key] ? 'checked' : '' ?>
                                                >

                                            </td>

                                        <?php endforeach; ?>

                                    </tr>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    </div>

                    <div class="alert alert-info mt-3 mb-0">

                        <strong>Note:</strong>

                        Permissions shown here are currently system-defined.
                        Dynamic permission management can be implemented later.

                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="createRoleModal">
    <div class="modal-dialog">

        <form method="post" action="<?= base_url('admin/roles/create') ?>" class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Create New Role</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <label class="form-label">Role Name</label>
                <input type="text" name="name" class="form-control" required>

            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button class="btn btn-primary">Create</button>
            </div>

        </form>

    </div>
</div>

<script>
document.querySelectorAll('.permission-toggle').forEach(cb => {

    cb.addEventListener('change', function () {

        fetch("<?= base_url('admin/role_permissions_settings/update') ?>", {
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded"
            },
            body: new URLSearchParams({
                id: this.dataset.id,
                key: this.dataset.key,
                value: this.checked ? 1 : 0,
                "<?= csrf_token() ?>": "<?= csrf_hash() ?>"
            })
        })
        .then(async res => {

            const text = await res.text();
            console.log("RAW RESPONSE:", text);

            try {
                return JSON.parse(text);
            } catch (e) {
                throw new Error("Invalid JSON response");
            }
        })
        .then(data => {

            if (data.status !== 'success') {
                alert(data.message || 'Failed to update permission');
                this.checked = !this.checked;
            }

        })
        .catch(err => {
            console.error(err);
            alert('Request failed');
        });

    });

});
</script>
<?= $this->endSection() ?>