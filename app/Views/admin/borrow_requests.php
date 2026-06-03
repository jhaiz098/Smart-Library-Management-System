<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Pending Borrow Requests
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Borrow Requests
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="p-3">
    <div class="card">
        <div class="card-header fw-bold">Borrow Requests</div>
        <div class="card-body">
            <div class="row">
                <div class="col-12">
                    <?php if(session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <div class="border-0 shadow-sm">

                        <ul class="nav nav-pills mb-3 border-bottom pb-2">

                            <li class="nav-item">
                                <a href="?type=all"
                                class="nav-link <?= ($request_status ?? '') == 'all' ? 'active' : '' ?>">
                                    All
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="?type=pending"
                                class="nav-link <?= ($request_status ?? '') == 'pending' ? 'active' : '' ?>">
                                    Pending
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="?type=approved"
                                class="nav-link <?= ($request_status ?? '') == 'approved' ? 'active' : '' ?>">
                                    Approved
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="?type=completed"
                                class="nav-link <?= ($request_status ?? '') == 'completed' ? 'active' : '' ?>">
                                    Completed
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="?type=expired"
                                class="nav-link <?= ($request_status ?? '') == 'expired' ? 'active' : '' ?>">
                                    Expired
                                </a>
                            </li>

                        </ul>

                        <div class="card p-3">
                            <p class="fs-6 fw-bold mb-3">
                                <?= ucfirst($request_status) ?> Borrow Requests
                            </p>

                            <?= $this->include('partials/admin/borrow_request_filters') ?>

                            <div class="table-responsive rounded-3 border bg-white shadow-sm">

                                <table class="table table-hover align-middle mb-0">
                                    <tr class="text-center">
                                        <th>#</th>
                                        <th>Borrower</th>
                                        <th>Book Title</th>
                                        <th>Request Date</th>
                                        <th>Status</th>
                                        <th colspan="2">Actions</th>
                                    </tr>
                                    <?php if(empty($records)): ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No borrow requests available</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php $i = 1; foreach($records as $pr): ?>
                                            <tr>
                                                <td class="text-center text-muted">
                                                    <?= $i++ ?>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold">
                                                        <?= esc($pr['full_name']) ?>
                                                    </div>

                                                    <div class="text-muted small">
                                                        <?= esc($pr['library_id']) ?>
                                                    </div>
                                                </td>
                                                <td class="fw-semibold">
                                                    <?= esc($pr['book_title']) ?>
                                                </td>
                                                <td><?= date('F d, Y', strtotime($pr['request_date'])) ?></td>
                                                <td>
                                                    <?php
                                                        $badge = match($pr['status']) {
                                                            'pending'   => 'warning',
                                                            'approved'  => 'primary',
                                                            'completed' => 'success',
                                                            'expired'   => 'danger',
                                                            default     => 'secondary'
                                                        };
                                                    ?>

                                                    <span class="badge bg-<?= $badge ?> rounded-pill px-3 py-2">
                                                        <?= ucfirst($pr['status']) ?>
                                                    </span>
                                                </td>
                                                <td class="text-center">

                                                    <div class="dropdown">

                                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                                data-bs-toggle="dropdown">
                                                            Actions
                                                        </button>

                                                        <ul class="dropdown-menu">

                                                            <?php if($pr['status'] === 'pending'): ?>

                                                                <li>
                                                                    <button class="dropdown-item text-success"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#approveModal"
                                                                        data-id="<?= $pr['id'] ?>">
                                                                        Approve
                                                                    </button>
                                                                </li>

                                                                <li>
                                                                    <button class="dropdown-item text-danger"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#rejectModal"
                                                                        data-id="<?= $pr['id'] ?>">
                                                                        Reject
                                                                    </button>
                                                                </li>
                                                            <?php elseif($pr['status'] === 'approved'): ?>
                                                            
                                                            <li>
                                                                <button
                                                                    type="button"
                                                                    class="dropdown-item text-success"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#claimModal"
                                                                    data-id="<?= $pr['id'] ?>"
                                                                    data-user="<?= $pr['full_name'] ?>"
                                                                    data-book="<?= $pr['book_title'] ?>"
                                                                    data-code="<?= $pr['claim_code'] ?>"
                                                                >
                                                                    Mark as Claimed
                                                                </button>
                                                            </li>
                                                            <?php endif; ?>


                                                        </ul>

                                                    </div>

                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </table>
                            </div>

                            <div class="mt-3 d-flex justify-content-center">
                                <?= $pager->links('default', 'bootstrap_full') ?>
                            </div>

                            <div class="modal fade" id="rejectModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <form method="post" id="rejectForm">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Reject Borrow Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                <p>Are you sure you want to reject this request?</p>

                                                <div class="mb-3">
                                                    <label class="form-label">Reason (optional)</label>
                                                    <textarea name="remarks" class="form-control"></textarea>
                                                </div>

                                                <input type="hidden" name="request_id" id="request_id">

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <button type="submit" class="btn btn-danger">
                                                    Confirm Reject
                                                </button>
                                            </div>

                                        </form>

                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="approveModal" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <form method="post" id="approveForm">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Approve Borrow Request</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">

                                                <p class="mb-3">
                                                    Are you sure you want to approve this borrow request?
                                                </p>

                                                <p class="text-muted small">
                                                    Once approved, the user will be allowed to claim the book at the library.
                                                </p>

                                                <input type="hidden" name="request_id" id="approve_request_id">

                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <button type="submit" class="btn btn-success">
                                                    Confirm Approve
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
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const rejectModal = document.getElementById('rejectModal');

    rejectModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const requestId = button.getAttribute('data-id');

        document.getElementById('request_id').value = requestId;

        // set dynamic form action
        document.getElementById('rejectForm').action =
            "<?= base_url('admin/borrow_requests/pending_borrow_requests_reject/') ?>" + requestId;
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const approveModal = document.getElementById('approveModal');

    approveModal.addEventListener('show.bs.modal', function (event) {
        const button = event.relatedTarget;
        const requestId = button.getAttribute('data-id');

        document.getElementById('approve_request_id').value = requestId;

        document.getElementById('approveForm').action =
            "<?= base_url('admin/borrow_requests/pending_borrow_requests_approve/') ?>" + requestId;
    });

});
</script>
<?= $this->endSection() ?>