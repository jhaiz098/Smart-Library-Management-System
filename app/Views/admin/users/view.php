<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    View User
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    User Details
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid p-3">

    <a href="/admin/users" class="btn btn-secondary mb-3">
        Back
    </a>

    <div class="row">

        <!-- PROFILE -->
        <div class="col-lg-4 mb-3">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">

                    <div
                        class="mx-auto mb-3 d-flex align-items-center justify-content-center text-white fw-bold"
                        style="
                            width:90px;
                            height:90px;
                            border-radius:50%;
                            background:#0d6efd;
                            font-size:32px;
                        ">
                        <?= strtoupper(substr($user['full_name'], 0, 1)) ?>
                    </div>

                    <h4 class="fw-bold mb-1">
                        <?= esc($user['full_name']) ?>
                    </h4>

                    <div class="text-muted mb-3">
                        <?= esc($user['email']) ?>
                    </div>

                    <?php if($user['role_id'] == 1): ?>

                        <span class="badge bg-dark px-3 py-2">
                            Administrator
                        </span>

                    <?php elseif($user['role_id'] == 2): ?>

                        <span class="badge bg-primary px-3 py-2">
                            Staff | <?= $user['staff_position'] ?>
                        </span>

                    <?php else: ?>

                        <span class="badge bg-secondary px-3 py-2">
                            User
                        </span>

                    <?php endif; ?>

                </div>

            </div>

        </div>

        <!-- DETAILS -->
        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-bold">
                    Account Information
                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <div class="small text-muted">
                                    Library ID
                                </div>

                                <div class="fw-semibold">
                                    <?= esc($user['library_id']) ?>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <div class="small text-muted">
                                    Contact Number
                                </div>

                                <div class="fw-semibold">
                                    <?= esc($user['contact_number']) ?>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <div class="small text-muted">
                                    Role
                                </div>

                                <div class="fw-semibold">
                                    <?= ucfirst($user['role_name']) ?>
                                </div>

                            </div>

                        </div>

                        <?php if($user['role_id'] == 2): ?>
                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <div class="small text-muted">
                                    Staff Position
                                </div>

                                <div class="fw-semibold">
                                    <?= esc($user['staff_position']) ?>
                                </div>

                            </div>

                        </div>
                        <?php endif; ?>

                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <div class="small text-muted">
                                    Status
                                </div>

                                <div>

                                    <?php if($user['status'] == 'activated'): ?>

                                        <span class="badge bg-success">
                                            Active
                                        </span>

                                    <?php else: ?>

                                        <span class="badge bg-danger">
                                            Inactive
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <div class="small text-muted">
                                    Created At
                                </div>

                                <div class="fw-semibold">
                                    <?= date('M d, Y h:i A', strtotime($user['created_at'])) ?>
                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <div class="border rounded p-3">

                                <div class="small text-muted">
                                    Updated At
                                </div>

                                <div class="fw-semibold">
                                    <?= date('M d, Y h:i A', strtotime($user['updated_at'])) ?>
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

            <!-- ACTIONS -->
            <div class="card border-0 shadow-sm mt-3">

                <div class="card-header bg-white fw-bold">
                    Actions
                </div>

                <div class="card-body d-flex gap-2">

                    <a href="/admin/users/edit/<?= $user['id'] ?>"
                        class="btn btn-warning">

                        <i class="bi bi-pencil"></i>
                        Edit

                    </a>

                    <?php if($user['status'] == 'activated'): ?>

                        <a href="/admin/users/deactivate/<?= $user['id'] ?>"
                            class="btn btn-danger">

                            <i class="bi bi-person-x"></i>
                            Deactivate

                        </a>

                    <?php else: ?>

                        <a href="/admin/users/activate/<?= $user['id'] ?>"
                            class="btn btn-success">

                            <i class="bi bi-person-check"></i>
                            Activate

                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>