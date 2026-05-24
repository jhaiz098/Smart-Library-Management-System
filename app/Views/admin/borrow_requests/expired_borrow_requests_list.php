<?= $this->extend('layouts/borrow_requests_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Expired Borrow Requests
<?= $this->endSection() ?>

<?= $this->section('render_requests') ?>
<div class="card p-3">
    <p class="fs-6 fw-bold">Expired Requests</p>

    <?= $this->include('partials/admin/borrow_request_filters') ?>

    <table class="table table-bordered fs-7">
        <tr class="text-center">
            <th>ID</th>
            <th>Borrower</th>
            <th>Book Title</th>
            <th>Status</th>
            <th>Request Date</th>
            <th>Expiration Date</th>
            <th>Remarks</th>
            <th>Actions</th>
        </tr>
        <?php if(empty($expired_requests)): ?>
            <tr>
                <td colspan="10" class="text-center">No borrow requests available</td>
            </tr>
        <?php else: ?>
            <?php foreach($expired_requests as $cr): ?>
                <tr>
                    <td><?= $cr['id'] ?></td>
                    <td><?= $cr['library_id'] ?> <br> <?= $cr['full_name'] ?></td>
                    <td><?= $cr['book_title'] ?></td>
                    <td><?= $cr['status'] ?></td>
                    <td><?= $cr['request_date'] ?></td>
                    <td><?= $cr['expires_at'] ?></td>
                    <td><?= $cr['remarks'] ?></td>
                    <td><button type="button" class="btn btn-sm btn-secondary">View</button></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>

    <div class="mt-3 d-flex justify-content-center">
        <?= $pager->links('default', 'bootstrap_full') ?>
    </div>

</div>
<?= $this->endSection() ?>