<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Users
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Users
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="p-3">
        <div class="card">
            <div class="card-header fw-bold">User's list</div>
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <!-- LEFT SIDE -->
                    <div>
                        <a class="btn btn-primary fs-7" href="/admin/users/add_user">
                            + Add User
                        </a>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <!-- SEARCH -->
                        <form method="get" action="<?= current_url() ?>" class="d-flex gap-2">

                            <input
                                type="search"
                                name="search"
                                placeholder="Search Full name..."
                                class="form-control"
                                value="<?= $_GET['search'] ?? '' ?>"
                            >

                            <button type="submit" class="btn btn-secondary">
                                Search
                            </button>

                            <!-- SORT -->
                            <select name="sort" class="form-select" onchange="this.form.submit()">
                                <option value="">Sort By</option>
                                <option value="name_asc" <?= ($sort ?? '') == 'name_asc' ? 'selected' : '' ?>>A-Z</option>
                                <option value="name_desc" <?= ($sort ?? '') == 'name_desc' ? 'selected' : '' ?>>Z-A</option>
                                <option value="newest" <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>Newest</option>
                                <option value="oldest" <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>Oldest</option>
                            </select>
                            
                            <!-- FILTER -->
                            <select name="role" class="form-select" onchange="this.form.submit()">
                                <option value="">All Roles</option>
                                <?php foreach($roles as $rol): ?>
                                    <option 
                                        value="<?= $rol['id'] ?>"
                                        <?= ($role ?? '') == $rol['id'] ? 'selected' : '' ?>
                                    >
                                        <?= $rol['name'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </form>
                    </div>
                </div>
                <table class="table table-bordered fs-7">
                    <tr>
                        <th>ID</th>
                        <th>Library ID</th>
                        <th>Staff Level ID</th>
                        <th>Full name</th>
                        <th>Email</th>
                        <th>Contact Number</th>
                        <th>Role (ID) Name</th>
                        <th>Status</th>
                        <th>Created at</th>
                        <th>Updated at</th>
                    </tr>
                    <?php if(empty($users)): ?>
                        <tr>
                            <td colspan="10" class="text-center">No users available</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($users as $user): ?>
                            <tr>
                                <td><?= $user['id'] ?></td>
                                <td><?= $user['library_id'] ?></td>
                                <td><?= $user['staff_level_id'] ?></td>
                                <td><?= $user['full_name'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['contact_number'] ?></td>
                                <td>(<?= $user['role_id'] ?>) <?= $user['role_name'] ?></td>
                                <td><?= $user['status'] ?></td>
                                <td><?= $user['created_at'] ?></td>
                                <td><?= $user['updated_at'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </table>

                <div class="mt-3 d-flex justify-content-center">
                    <?= $pager->links('default', 'bootstrap_full') ?>
                </div>
            </div>
        </div>
    </div>
<?= $this->endSection() ?>