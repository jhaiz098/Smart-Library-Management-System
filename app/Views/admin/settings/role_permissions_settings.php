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

                        <div class="table-responsive">

                            <table class="table table-bordered table-hover align-middle">

                                <thead class="table-light text-center">
                                    <tr>
                                        <th width="25%">Permission</th>

                                        <?php foreach($permissions as $perm): ?>
                                            <th><?= esc($perm['label']) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>

                                <tbody>

                                <?php
                                $permission_keys = [
                                    'can_manage_users' => 'Manage Users',
                                    'can_manage_books' => 'Manage Books',
                                    'can_process_borrow_requests' => 'Borrow Requests',
                                    'can_manage_borrowed_books' => 'Borrowed Books',
                                    'can_extend_borrowings' => 'Extend Borrowings',
                                    'can_process_returns' => 'Process Returns',
                                    'can_manage_fines' => 'Manage Fines',
                                    'can_manage_settings' => 'System Settings',
                                    'can_manage_roles_permissions' => 'Roles & Permissions'
                                ];
                                ?>

                                <?php foreach($permission_keys as $key => $label): ?>

                                    <tr>
                                        <td class="fw-semibold">
                                            <?= esc($label) ?>
                                        </td>

                                        <?php foreach($permissions as $perm): ?>

                                            <td class="text-center">
                                                <?php $allowed = (bool) ($perm[$key] ?? false); ?>

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