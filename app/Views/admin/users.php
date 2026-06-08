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
        <div class="card-header bg-white">
            
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
                <div>
                    <h5 class="fw-bold mb-1">User Management</h5>
                    <div class="text-muted small">
                        Manage library users, staff, and roles
                    </div>
                </div>
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body">
            <ul class="nav nav-pills gap-2 mb-3">

                <li class="nav-item">
                    <a href="?type=all"
                    class="nav-link <?= ($type ?? 'all') == 'all' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-people-fill me-1"></i>
                        All Users

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=user"
                    class="nav-link <?= ($type ?? '') == 'user' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-person-fill me-1"></i>
                        Users

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=staff"
                    class="nav-link <?= ($type ?? '') == 'staff' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-person-badge-fill me-1"></i>
                        Staff

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=admin"
                    class="nav-link <?= ($type ?? '') == 'admin' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-shield-lock-fill me-1"></i>
                        Admin

                    </a>
                </li>

            </ul>
            
            <!-- SEARCH + FILTER -->
            <div class="filter-toolbar">
                <form method="get" action="<?= current_url() ?>" class="row g-2 align-items-center">
                    <input type="hidden" name="type" value="<?= esc($type) ?>">

                    <!-- Search -->
                    <div class="col-md-6">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input
                                type="search"
                                name="search"
                                placeholder="Search library ID, full name, email..."
                                class="form-control"
                                value="<?= $_GET['search'] ?? '' ?>"
                            >
                        </div>
                    </div>

                    <div class="col-md-2">
                        <button class="btn btn-primary w-100">
                            Search
                        </button>
                    </div>

                    <!-- Sort -->
                    <div class="col-md-2">
                        <select name="sort" class="form-select filter-select" onchange="this.form.submit()">
                            <option value="">Sort By</option>
                            <option value="name_asc" <?= ($sort ?? '') == 'name_asc' ? 'selected' : '' ?>>
                                Name Ascending
                            </option>
                            <option value="name_desc" <?= ($sort ?? '') == 'name_desc' ? 'selected' : '' ?>>
                                Name Descending
                            </option>
                            <option value="newest" <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>
                                Recently Created
                            </option>
                            <option value="oldest" <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>
                                Earliest Created
                            </option>
                        </select>
                    </div>

                    <?php if($type != 'user' && $type != 'admin' && $type != 'staff'): ?>
                    <div class="col-md-2">
                        <select name="role" class="form-select filter-select" onchange="this.form.submit()">
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
            </div>
            
            

            <hr>

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

            <a class="btn btn-primary btn-sm px-3 py-2 my-2" href="/admin/users/add_user">
                + Add User
            </a>

            <!-- TABLE -->
            <div class="table-responsive rounded-3 border bg-white shadow-sm">

                <table class="table table-hover align-middle mb-0 fs-6">

                    <thead class="bg-light border-bottom">
                        <tr class="text-muted small">
                            <th>#</th>
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

                            <?php
                            $currentPage = $pager->getCurrentPage();
                            $perPage = 10;

                            $i = (($currentPage - 1) * $perPage) + 1;
                            ?>
                            
                            <?php foreach($users as $user): ?>

                                <tr>

                                    <!-- # -->
                                    <td class="text-muted fw-semibold">
                                        <?= $i++ ?>
                                    </td>

                                    <!-- LIBRARY ID -->
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2 rounded-pill">
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
                                            <span class="badge bg-dark rounded-pill px-3 py-2">Admin</span>
                                        <?php elseif($user['role_id'] == 2): ?>
                                            <span class="badge bg-primary rounded-pill px-3 py-2">Staff</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary rounded-pill px-3 py-2">User</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>
                                    
                                    <?php if($type != 'user' && $type != 'admin'): ?>
                                    <!-- STAFF LEVEL -->
                                    <td>
                                        <?php if(!empty($user['staff_level_name'])): ?>
                                            <span class="badge rounded-pill border bg-warning text-dark px-3 py-2 fw-medium">
                                                <?= esc($user['staff_level_name']) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>
                                    <?php endif; ?>

                                    <!-- STATUS -->
                                    <td>
                                        <?php if($user['status'] == 'activated'): ?>
                                            <span class="badge bg-success rounded-pill px-3 py-2">Active</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger rounded-pill px-3 py-2">Inactive</span>
                                        <?php endif; ?>
                                    </td>

                                    <!-- CREATED -->
                                    <td class="text-muted small">
                                        <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                    </td>

                                    <!-- ACTIONS -->
                                    <td>

                                        <div class="dropdown">

                                            <button
                                                class="btn btn-sm btn-outline-secondary dropdown-toggle px-3"
                                                data-bs-toggle="dropdown">

                                                <i class="bi bi-gear-fill me-1"></i>
                                                Actions

                                            </button>

                                            <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">

                                                <!-- VIEW -->
                                                <li>

                                                    <a class="dropdown-item"
                                                    href="/admin/users/view/<?= $user['id'] ?>">

                                                        <i class="bi bi-eye me-2"></i>
                                                        View

                                                    </a>

                                                </li>

                                                <?php if($user['role_id'] != 1): ?>

                                                    <!-- EDIT -->
                                                    <li>

                                                        <a class="dropdown-item"
                                                        href="/admin/users/edit/<?= $user['id'] ?>">

                                                            <i class="bi bi-pencil-square me-2"></i>
                                                            Edit

                                                        </a>

                                                    </li>

                                                    <!-- RESET PASSWORD -->
                                                    <li>

                                                        <button
                                                            type="button"
                                                            class="dropdown-item text-info"

                                                            data-bs-toggle="modal"
                                                            data-bs-target="#resetPasswordModal<?= $user['id'] ?>">

                                                            <i class="bi bi-key me-2"></i>
                                                            Reset Password

                                                        </button>

                                                    </li>

                                                    <li>
                                                        <hr class="dropdown-divider">
                                                    </li>

                                                    <!-- ACTIVATE / DEACTIVATE -->
                                                    <li>

                                                        <button
                                                            type="button"
                                                            class="dropdown-item text-warning"

                                                            data-bs-toggle="modal"
                                                            data-bs-target="#statusModal<?= $user['id'] ?>">

                                                            <i class="bi bi-toggle-on me-2"></i>

                                                            <?= $user['status'] == 'activated'
                                                                ? 'Deactivate'
                                                                : 'Activate' ?>

                                                        </button>

                                                    </li>

                                                <?php endif; ?>

                                            </ul>

                                        </div>

                                    </td>

                                </tr>

                                <div class="modal fade"
                                    id="statusModal<?= $user['id'] ?>"
                                    tabindex="-1"
                                    aria-labelledby="statusModalLabel<?= $user['id'] ?>"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5 class="modal-title"
                                                    id="statusModalLabel<?= $user['id'] ?>">

                                                    <?= $user['status'] == 'activated'
                                                        ? 'Deactivate User'
                                                        : 'Activate User' ?>

                                                </h5>

                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal">
                                                </button>

                                            </div>

                                            <div class="modal-body">

                                                <p class="mb-2">

                                                    Are you sure you want to

                                                    <strong>
                                                        <?= $user['status'] == 'activated'
                                                            ? 'deactivate'
                                                            : 'activate' ?>
                                                    </strong>

                                                    this user?

                                                </p>

                                                <div class="fw-bold">
                                                    <?= esc($user['full_name']) ?>
                                                </div>

                                                <div class="text-muted small">
                                                    <?= esc($user['library_id']) ?>
                                                </div>

                                                <?php if($user['status'] == 'activated'): ?>

                                                    <div class="alert alert-warning mt-3 mb-0">
                                                        The user will no longer be able to access their account.
                                                    </div>

                                                <?php else: ?>

                                                    <div class="alert alert-success mt-3 mb-0">
                                                        The user will regain access to their account.
                                                    </div>

                                                <?php endif; ?>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-light border"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/admin/users/toggle_status/<?= $user['id'] ?>"
                                                class="btn <?= $user['status'] == 'activated'
                                                                    ? 'btn-warning'
                                                                    : 'btn-success' ?>">

                                                    <?= $user['status'] == 'activated'
                                                        ? 'Deactivate'
                                                        : 'Activate' ?>

                                                </a>

                                            </div>

                                        </div>

                                    </div>

                                </div>
                                
                                <div class="modal fade"
                                    id="resetPasswordModal<?= $user['id'] ?>"
                                    tabindex="-1"
                                    aria-labelledby="resetPasswordLabel<?= $user['id'] ?>"
                                    aria-hidden="true">

                                    <div class="modal-dialog modal-dialog-centered">

                                        <div class="modal-content">

                                            <div class="modal-header">

                                                <h5
                                                    class="modal-title"
                                                    id="resetPasswordLabel<?= $user['id'] ?>">
                                                    Reset Password
                                                </h5>

                                                <button
                                                    type="button"
                                                    class="btn-close"
                                                    data-bs-dismiss="modal">
                                                </button>

                                            </div>

                                            <div class="modal-body">

                                                <p class="mb-2">
                                                    Are you sure you want to reset the password for:
                                                </p>

                                                <div class="fw-bold">
                                                    <?= esc($user['full_name']) ?>
                                                </div>

                                                <div class="text-muted small">
                                                    <?= esc($user['library_id']) ?>
                                                </div>

                                                <div class="alert alert-warning mt-3 mb-0">
                                                    A temporary password will be generated and must be provided to the user.
                                                </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button
                                                    type="button"
                                                    class="btn btn-light border"
                                                    data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <form
                                                    action="/admin/users/reset_password/<?= $user['id'] ?>"
                                                    method="post">

                                                    <?= csrf_field() ?>

                                                    <button
                                                        type="submit"
                                                        class="btn btn-warning">
                                                        Reset Password
                                                    </button>

                                                </form>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

                <?php if(session()->getFlashdata('temp_password')): ?>

                <div class="modal fade" id="tempPasswordModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">

                        <div class="modal-content border-0 shadow">

                            <div class="modal-header bg-warning">
                                <h5 class="modal-title">Temporary Password Generated</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>

                            <div class="modal-body text-center">

                                <p class="mb-2">Give this password to the user:</p>

                                <div class="p-3 bg-light border rounded fw-bold fs-5">
                                    <?= session()->getFlashdata('temp_password') ?>
                                </div>

                                <small class="text-muted">
                                    User must change this password on first login.
                                </small>

                            </div>

                            <div class="modal-footer">
                                <button class="btn btn-dark w-100" data-bs-dismiss="modal">
                                    OK
                                </button>
                            </div>

                        </div>

                    </div>
                </div>

                <?php endif; ?>

            </div>

            <!-- PAGINATION -->
            <div class="mt-3 d-flex justify-content-center">
                <?= $pager->links('default', 'bootstrap_full') ?>
            </div>

        </div>

    </div>

</div>

<?php if(session()->getFlashdata('temp_password')): ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('tempPasswordModal'));
        modal.show();
    });
</script>

<?php endif; ?>

<style>
    .table tbody tr:hover {
        background: #f8f9fa;
    }
    .filter-toolbar{
        background: #fff;
        padding: 14px;
        border: 1px solid #e9ecef;
        border-radius: 14px;
    }

    .search-box{
        position: relative;
    }

    .search-box i{
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 2;
    }

    .search-box .form-control{
        padding-left: 40px;
        border-radius: 10px;
        border: 1px solid #dee2e6;
        height: 42px;
    }

    .filter-select{
        border-radius: 10px;
        height: 42px;
    }

    .filter-select:focus,
    .search-box .form-control:focus{
        border-color: #86b7fe;
        box-shadow: 0 0 0 .15rem rgba(13,110,253,.15);
    }

    .filter-toolbar .btn-primary{
        height: 42px;
        border-radius: 10px;
        font-weight: 600;
    }
</style>

<?= $this->endSection() ?>