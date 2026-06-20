<?= $this->extend('layouts/borrow_requests_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Pending Borrow Requests
<?= $this->endSection() ?>

<?= $this->section('render_requests') ?>
<div class="card p-3">
    <p class="fs-6 fw-bold">Pending Requests</p>

    <?= $this->include('partials/admin/borrow_request_filters') ?>

    <table class="table table-bordered fs-7">
        <tr class="text-center">
            <th>ID</th>
            <th>Borrower</th>
            <th>Book Title</th>
            <th>Request Date</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php if(empty($pending_requests)): ?>
            <tr>
                <td colspan="10" class="text-center">No borrow requests available</td>
            </tr>
        <?php else: ?>
            <?php foreach($pending_requests as $pr): ?>
                <tr>
                    <td><?= $pr['id'] ?></td>
                    <td><?= $pr['library_id'] ?> <br> <?= $pr['full_name'] ?></td>
                    <td><?= $pr['book_title'] ?></td>
                    <td><?= $pr['request_date'] ?></td>
                    <td>
                        <button
                            type="button"
                            class="btn btn-success"
                            data-bs-toggle="modal"
                            data-bs-target="#approveModal"
                            data-id="<?= $pr['id'] ?>"
                        >
                            Approve
                        </button>
                    </td>
                    <td>
                        <button
                            type="button"
                            class="btn btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#rejectModal"
                            data-id="<?= $pr['id'] ?>"
                        >
                            Reject
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

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