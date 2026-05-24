<?= $this->extend('layouts/User/my_transactions_layout') ?>

<?= $this->section('title') ?>
    User | My Transactions
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    My Transactions
<?= $this->endSection() ?>

<?= $this->section('render_transactions') ?>

<div class="">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div class="fw-bold">
                Borrow Requests
            </div>

            <span class="badge bg-primary">
                <?= count($borrow_requests) ?>
            </span>

        </div>

        <div class="card-body p-0">

            <?php if(!empty($borrow_requests)): ?>

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Book</th>
                                <th>Request Date</th>
                                <th>Status</th>
                                <th>Claim Code</th>
                                <th width="15%">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($borrow_requests as $request): ?>

                                <tr>

                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($request['title']) ?>
                                        </div>

                                        <div class="small text-muted">
                                            <?= esc($request['author']) ?>
                                        </div>

                                    </td>

                                    <td>

                                        <?= 
                                            !empty($request['created_at'])
                                            ? date('M d, Y', strtotime($request['created_at']))
                                            : '-'
                                        ?>

                                    </td>

                                    <td>

                                        <?php if($request['status'] == 'pending'): ?>

                                            <span class="badge bg-warning text-dark">
                                                Pending
                                            </span>

                                        <?php elseif($request['status'] == 'approved'): ?>

                                            <span class="badge bg-success">
                                                Approved
                                            </span>

                                        <?php elseif($request['status'] == 'rejected'): ?>

                                            <span class="badge bg-danger">
                                                Rejected
                                            </span>

                                        <?php elseif($request['status'] == 'cancelled'): ?>

                                            <span class="badge bg-secondary">
                                                Cancelled
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-dark">
                                                <?= ucfirst($request['status']) ?>
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?php if($request['status'] == 'approved'): ?>

                                            <span class="fw-bold text-success">
                                                <?= esc($request['claim_code']) ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                -
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <a href="<?= site_url('user/books/view/' . $request['book_id']) ?>"
                                            class="btn btn-sm btn-primary">

                                            View

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="p-4 text-center text-muted">

                    <div class="mb-2 fs-5">
                        No borrow requests found.
                    </div>

                    <div class="small">
                        Your borrow requests will appear here.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>