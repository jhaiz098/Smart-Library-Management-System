<?= $this->extend('layouts/borrow_requests_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Approved Borrow Requests
<?= $this->endSection() ?>

<?= $this->section('render_requests') ?>
<div class="card p-3">
    <p class="fs-6 fw-bold">Processed Requests</p>

    <?= $this->include('partials/admin/borrow_request_filters') ?>

    <table class="table table-bordered fs-7">
        <tr class="text-center">
            <th>ID</th>
            <th>Borrower</th>
            <th>Book Title</th>
            <th>Request Date</th>
            <th>Processed At</th>
            <th>Processed By</th>
            <th>Remarks</th>
            <th>Claim Code</th>
            <th colspan="2">Actions</th>
        </tr>
        <?php if(empty($approved_requests)): ?>
            <tr>
                <td colspan="10" class="text-center">No borrow requests available</td>
            </tr>
        <?php else: ?>
            <?php foreach($approved_requests as $ar): ?>
                <tr>
                    <td><?= $ar['id'] ?></td>
                    <td><?= $ar['library_id'] ?> <br> <?= $ar['full_name'] ?></td>
                    <td><?= $ar['book_title'] ?></td>
                    <td><?= $ar['request_date'] ?></td>
                    <td><?= $ar['processed_at'] ?></td>
                    <td><?= $ar['processed_by_library_id'] ?> <br> <?= $ar['processed_by_name'] ?></td>
                    <td><?= $ar['remarks'] ?></td>
                    <td><?= $ar['claim_code'] ?></td>
                    <td>
                        <button
                            type="button"
                            class="btn btn-success btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#claimModal"
                            data-id="<?= $ar['id'] ?>"
                            data-user="<?= $ar['full_name'] ?>"
                            data-book="<?= $ar['book_title'] ?>"
                            data-code="<?= $ar['claim_code'] ?>"
                        >
                            Mark as Claimed
                        </button>
                    </td>
                    <td>
                        <button 
                            class="btn btn-danger btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#cancelModal"
                            data-id="<?= $ar['id'] ?>"
                            data-user="<?= $ar['full_name'] ?>"
                            data-book="<?= $ar['book_title'] ?>"
                            data-status="<?= $ar['status'] ?>">
                            Cancel Approved Request
                        </button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
    <div class="mt-3 d-flex justify-content-center">
        <?= $pager->links('default', 'bootstrap_full') ?>
    </div>
</div>

<div class="modal fade" id="claimModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="claimForm">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Confirm Book Claim
                    </h5>

                    <button 
                        type="button" 
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <p>
                        Are you sure this book has been successfully claimed by the borrower?
                    </p>

                    <table class="table table-bordered">
                        <tr>
                            <th>Borrower</th>
                            <td id="claim_user"></td>
                        </tr>

                        <tr>
                            <th>Book</th>
                            <td id="claim_book"></td>
                        </tr>

                        <tr>
                            <th>Claim Code</th>
                            <td id="claim_code"></td>
                        </tr>
                    </table>

                    <div class="mb-3">
                        <label class="form-label">
                            Remarks (Optional)
                        </label>

                        <textarea 
                            name="remarks"
                            class="form-control"
                            placeholder="Book handed over successfully..."></textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button 
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button 
                        type="submit"
                        class="btn btn-success">
                        Confirm Claim
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="cancelModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" id="cancelForm">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Confirm Cancellation
                    </h5>

                    <button 
                        type="button" 
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <p>
                        Are you sure you want to cancel this borrow request?
                    </p>

                    <table class="table table-bordered">
                        <tr>
                            <th>Borrower</th>
                            <td id="cancel_user"></td>
                        </tr>

                        <tr>
                            <th>Book</th>
                            <td id="cancel_book"></td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td id="cancel_status"></td>
                        </tr>
                    </table>

                    <div class="mb-3">
                        <label class="form-label">
                            Remarks (Optional)
                        </label>

                        <textarea 
                            name="remarks"
                            class="form-control"
                            placeholder="Cancelled due to..."></textarea>
                    </div>

                </div>

                <div class="modal-footer">

                    <button 
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Keep Request
                    </button>

                    <button 
                        type="submit"
                        class="btn btn-danger">
                        Confirm Cancel
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const claimModal = document.getElementById('claimModal');

    claimModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const requestId = button.getAttribute('data-id');
        const user = button.getAttribute('data-user');
        const book = button.getAttribute('data-book');
        const code = button.getAttribute('data-code');

        // set values
        document.getElementById('claim_user').innerText = user;
        document.getElementById('claim_book').innerText = book;
        document.getElementById('claim_code').innerText = code;

        // dynamic form action
        document.getElementById('claimForm').action =
            "<?= base_url('admin/borrow_requests/approved_borrow_requests_claim/') ?>" + requestId;
    });

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const cancelModal = document.getElementById('cancelModal');

    cancelModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const requestId = button.getAttribute('data-id');
        const user = button.getAttribute('data-user');
        const book = button.getAttribute('data-book');
        const status = button.getAttribute('data-status');

        // set modal values
        document.getElementById('cancel_user').innerText = user;
        document.getElementById('cancel_book').innerText = book;
        document.getElementById('cancel_status').innerText = status;

        // set form action
        document.getElementById('cancelForm').action =
            "<?= base_url('admin/borrow_requests/approved_borrow_requests_cancel/') ?>" + requestId;
    });

});
</script>

<?= $this->endSection() ?>