<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Users
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Users
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>
                <div class="fw-bold fs-5">User Management</div>
                <div class="text-muted small">
                    Manage library users, staff, and roles
                </div>
            </div>

            <a class="btn btn-primary btn-sm px-3" href="/admin/users/add_user">
                + Add User
            </a>

        </div>

        <!-- BODY -->
        <div class="card-body">
            <ul class="nav nav-tabs mb-3">

                <li class="nav-item">
                    <a href="?type=all" class="nav-link <?= ($type ?? 'all') == 'all' ? 'active' : '' ?>">
                        All Users
                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=user" class="nav-link <?= ($type ?? '') == 'user' ? 'active' : '' ?>">
                        Users
                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=staff" class="nav-link <?= ($type ?? '') == 'staff' ? 'active' : '' ?>">
                        Staff
                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=admin" class="nav-link <?= ($type ?? '') == 'admin' ? 'active' : '' ?>">
                        Admin
                    </a>
                </li>

            </ul>
            <!-- SEARCH + FILTER -->
            <form method="get" action="<?= current_url() ?>" class="row g-2 mb-3">
                <input type="hidden" name="type" value="<?= esc($type) ?>">
                <div class="col-md-4">
                    <input
                        type="search"
                        name="search"
                        placeholder="Search full name..."
                        class="form-control"
                        value="<?= $_GET['search'] ?? '' ?>"
                    >
                </div>

                <div class="col-md-3">
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Sort By</option>
                        <option value="name_asc" <?= ($sort ?? '') == 'name_asc' ? 'selected' : '' ?>>Name Ascending</option>
                        <option value="name_desc" <?= ($sort ?? '') == 'name_desc' ? 'selected' : '' ?>>Name Descending</option>
                        <option value="newest" <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>Recently created</option>
                        <option value="oldest" <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>Earliest created</option>
                    </select>
                </div>

                <?php if($type != 'user' && $type != 'admin' && $type != 'staff'): ?>
                <div class="col-md-3">
                    <select name="role" class="form-select" onchange="this.form.submit()">
                        <option value="">All Roles</option>
                        <?php foreach($roles as $rol): ?>
                            <option value="<?= $rol['id'] ?>"
                                <?= ($role ?? '') == $rol['id'] ? 'selected' : '' ?>>
                                <?= ucfirst($rol['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>

            </form>

            <!-- TABLE -->
            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">

                        <tr class="text-muted small">
                            <th style="width:60px;">#</th>
                            <th>Library ID</th>
                            <th>Full Name</th>
                            <th>Email</th>
                            <th>Contact</th>
                            <?php if($type != 'user' && $type != 'admin' && $type != 'staff'): ?>
                            <th>Role</th>
                            <?php endif; ?>
                            <?php if($type != 'user' && $type != 'admin'): ?>
                            <th>Staff Position</th>
                            <?php endif; ?>
                            <th>Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if(empty($users)): ?>

                            <tr>
                                <td colspan="9" class="text-center text-muted py-4">
                                    No users available
                                </td>
                            </tr>

                        <?php else: ?>

                            <?php $i = 1; foreach($users as $user): ?>

                                <tr>

                                    <!-- # -->
                                    <td class="text-muted fw-semibold">
                                        <?= $i++ ?>
                                    </td>

                                    <!-- LIBRARY ID -->
                                    <td>
                                        <span class="badge bg-light text-dark border">
                                            <?= $user['library_id'] ?>
                                        </span>
                                    </td>

                                    <!-- NAME -->
                                    <td class="fw-semibold">
                                        <?= esc($user['full_name']) ?>
                                    </td>

                                    <!-- EMAIL -->
                                    <td class="text-muted">
                                        <?= esc($user['email']) ?>
                                    </td>

                                    <!-- CONTACT -->
                                    <td class="text-muted">
                                        <?= esc($user['contact_number']) ?>
                                    </td>

                                    <?php if($type != 'user' && $type != 'admin' && $type != 'staff'): ?>
                                    <!-- ROLE -->
                                    <td>
                                        <?php if($user['role_id'] == 1): ?>
                                            <span class="badge bg-dark">Admin</span>
                                        <?php elseif($user['role_id'] == 2): ?>
                                            <span class="badge bg-primary">Staff</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">User</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                    
                                    <?php if($type != 'user' && $type != 'admin'): ?>
                                    <!-- STAFF LEVEL -->
                                    <td class="text-muted">
                                        <?= $user['staff_level_id'] ?? '-' ?>
                                    </td>
                                    <?php endif; ?>

                                    <!-- STATUS -->
                                    <td>
                                        <?php if($user['status'] == 'activated'): ?>
                                            <span class="badge bg-success">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Inactive</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- CREATED -->
                                    <td class="text-muted small">
                                        <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                    </td>

                                    <!-- ACTIONS -->
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-sm btn-light border dropdown-toggle" data-bs-toggle="dropdown">
                                                Actions
                                            </button>

                                            <ul class="dropdown-menu">

                                                <li>
                                                    <a class="dropdown-item" href="/admin/users/view/<?= $user['id'] ?>">
                                                        View
                                                    </a>
                                                </li>

                                                <li>
                                                    <a class="dropdown-item" href="/admin/users/edit/<?= $user['id'] ?>">
                                                        Edit
                                                    </a>
                                                </li>

                                                <li><hr class="dropdown-divider"></li>

                                                <li>
                                                    <a class="dropdown-item text-warning" href="#">
                                                        <?= $user['status'] == 'activated' ? 'Deactivate' : 'Activate' ?>
                                                    </a>
                                                </li>

                                            </ul>
                                        </div>
                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="mt-3 d-flex justify-content-center">
                <?= $pager->links('default', 'bootstrap_full') ?>
            </div>

        </div>

    </div>

</div>

<style>
    .table tbody tr:hover {
        background: #f8f9fa;
    }

    .card-header {
        background: #ffffff;
        border-bottom: 1px solid #eee;
    }
</style>

<?= $this->endSection() ?>