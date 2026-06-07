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
                                        'can_manage_borrowed_books' => 'Manage Borrowed Books',
                                        'can_manage_borrow_requests' => 'Manage Borrow Requests',
                                        'can_manage_reservations' => 'Manage Reservations',
                                        'can_manage_fines' => 'Manage Fines',
                                        'can_manage_settings' => 'Manage Settings',
                                    ];
                                    ?>

                                    <?php foreach($permission_keys as $key => $label): ?>
                                        <th><?= esc($label) ?></th>
                                    <?php endforeach; ?>
                                        <th>Actions</th>
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
                                                    <?= ($perm['label'] == 'Admin') ? 'disabled' : '' ?>
                                                >

                                            </td>

                                        <?php endforeach; ?>
                                            <td class="text-center">

                                                <?php if($perm['label'] != 'Admin'): ?>
                                                <div class="dropdown">

                                                    <button
                                                        class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                        data-bs-toggle="dropdown">

                                                        Actions

                                                    </button>

                                                    <ul class="dropdown-menu">

                                                        <!-- EDIT -->
                                                        <li>

                                                            <button
                                                                class="dropdown-item"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#editRoleModal"

                                                                data-id="<?= $perm['staff_level_id'] ?>"
                                                                data-name="<?= esc($perm['label']) ?>">

                                                                <i class="bi bi-pencil-square me-2"></i>
                                                                Edit Role

                                                            </button>

                                                        </li>

                                                        <li>
                                                            <hr class="dropdown-divider">
                                                        </li>

                                                        <!-- DELETE -->
                                                        <li>

                                                            <button
                                                                class="dropdown-item text-danger"

                                                                data-bs-toggle="modal"
                                                                data-bs-target="#deleteRoleModal"

                                                                data-id="<?= $perm['staff_level_id'] ?>"
                                                                data-name="<?= esc($perm['label']) ?>">

                                                                <i class="bi bi-trash me-2"></i>
                                                                Delete Role

                                                            </button>

                                                        </li>

                                                    </ul>

                                                </div>
                                                <?php else: ?>
                                                    —
                                                <?php endif; ?>

                                            </td>
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

<div class="modal fade" id="editRoleModal" tabindex="-1">

    <div class="modal-dialog">

        <form method="post"
              action="<?= base_url('admin/roles/edit') ?>"
              class="modal-content">

            <input type="hidden"
                   name="id"
                   id="edit_role_id">

            <div class="modal-header">

                <h5 class="modal-title">
                    Edit Role
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="mb-3">

                    <label class="form-label">
                        Role Name
                    </label>

                    <input type="text"
                           name="name"
                           id="edit_role_name"
                           class="form-control"
                           required>

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                    Cancel

                </button>

                <button type="submit"
                        class="btn btn-primary">

                    Save Changes

                </button>

            </div>

        </form>

    </div>

</div>

<div class="modal fade" id="deleteRoleModal" tabindex="-1">

    <div class="modal-dialog">

        <form method="post"
              action="<?= base_url('admin/roles/delete') ?>"
              class="modal-content">

            <input type="hidden"
                   name="id"
                   id="delete_role_id">

            <div class="modal-header">

                <h5 class="modal-title text-danger">
                    Delete Role
                </h5>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <p class="mb-0">

                    Are you sure you want to delete the role

                    <strong id="delete_role_name"></strong>?

                </p>

                <div class="alert alert-warning mt-3 mb-0">

                    This action cannot be undone.

                </div>

            </div>

            <div class="modal-footer">

                <button type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">

                    Cancel

                </button>

                <button type="submit"
                        class="btn btn-danger">

                    Delete Role

                </button>

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


document.addEventListener('DOMContentLoaded', function () {

    const editRoleModal = document.getElementById('editRoleModal');

    editRoleModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        document.getElementById('edit_role_id').value =
            button.getAttribute('data-id');

        document.getElementById('edit_role_name').value =
            button.getAttribute('data-name');
    });

    const deleteRoleModal = document.getElementById('deleteRoleModal');

    deleteRoleModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        document.getElementById('delete_role_id').value =
            button.getAttribute('data-id');

        document.getElementById('delete_role_name').textContent =
            button.getAttribute('data-name');
    });

});
</script>
<?= $this->endSection() ?>