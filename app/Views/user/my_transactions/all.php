<?= $this->extend('layouts/User/my_transactions_layout') ?>

<?= $this->section('title') ?>
    User | My Transactions
<?= $this->endSection() ?>

<?= $this->section('render_transactions') ?>

<div class="">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">All Transactions</div>
                <div class="text-muted small">
                    Borrowings, requests, and reservations combined
                </div>
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-0">

            <?php if(!empty($transactions)): ?>

                <?php
                    $perPage = $pager->getPerPage('default');
                    $page = $pager->getCurrentPage('default');
                    $i = ($page - 1) * $perPage + 1;
                ?>

                <div class="table-responsive">

                    <table class="table align-middle mb-0">

                        <thead class="table-light">

                            <tr class="text-muted small">
                                <th>#</th>
                                <th>Reference No.</th>
                                <th>Book</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($transactions as $transaction): ?>

                                <tr>

                                    <!-- # -->
                                    <td class="text-muted fw-semibold">
                                        <?= $i++ ?>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill bg-dark px-3 py-2">
                                            <?= ucfirst($request['borrow_request_code']) ?>
                                        </span>
                                    </td>

                                    <!-- BOOK -->
                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($transaction['title']) ?>
                                        </div>

                                        <div class="small text-muted">
                                            <?= esc($transaction['author']) ?>
                                        </div>

                                    </td>

                                    <!-- TYPE -->
                                    <td>

                                        <?php if($transaction['transaction_type'] == 'borrowing'): ?>

                                            <span class="badge rounded-pill bg-success px-3 py-2">
                                                Borrowing
                                            </span>

                                        <?php elseif($transaction['transaction_type'] == 'borrow_request'): ?>

                                            <span class="badge rounded-pill bg-primary px-3 py-2">
                                                Borrow Request
                                            </span>

                                        <?php elseif($transaction['transaction_type'] == 'reservation'): ?>

                                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                                Reservation
                                            </span>

                                        <?php else: ?>

                                            <span class="badge rounded-pill bg-dark px-3 py-2">
                                                <?= ucfirst($transaction['transaction_type']) ?>
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- DATE -->
                                    <td class="text-muted">

                                        <?= 
                                            !empty($transaction['created_at'])
                                            ? date('M d, Y', strtotime($transaction['created_at']))
                                            : '-'
                                        ?>

                                    </td>

                                    <!-- STATUS -->
                                    <td>

                                        <?php $status = $transaction['status'] ?? null; ?>

                                        <?php if($transaction['transaction_type'] == 'borrowing'): ?>

                                            <?php if($transaction['status'] == 'borrowed'): ?>
                                                <span class="badge rounded-pill bg-primary px-3 py-2">Borrowed</span>

                                            <?php elseif($transaction['status'] == 'returned'): ?>
                                                <span class="badge rounded-pill bg-success px-3 py-2">Returned</span>
                                            <?php endif; ?>

                                        <?php elseif($transaction['transaction_type'] == 'borrow_request'): ?>

                                            <?php if($transaction['status'] == 'pending'): ?>
                                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">Pending</span>

                                            <?php elseif($transaction['status'] == 'approved'): ?>
                                                <span class="badge rounded-pill bg-info text-dark px-3 py-2">Approved</span>

                                            <?php elseif($transaction['status'] == 'claimed'): ?>
                                                <span class="badge rounded-pill bg-success px-3 py-2">Claimed</span>

                                            <?php elseif($transaction['status'] == 'rejected'): ?>
                                                <span class="badge rounded-pill bg-danger px-3 py-2">Rejected</span>

                                            <?php elseif($transaction['status'] == 'expired'): ?>
                                                <span class="badge rounded-pill bg-secondary px-3 py-2">Expired</span>

                                            <?php elseif($transaction['status'] == 'cancelled'): ?>
                                                <span class="badge rounded-pill bg-dark px-3 py-2">Cancelled</span>

                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-secondary px-3 py-2">Unknown</span>
                                            <?php endif; ?>

                                        <?php elseif($transaction['transaction_type'] == 'reservation'): ?>

                                            <?php if($transaction['status'] == 'pending'): ?>
                                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">Waiting</span>

                                            <?php elseif($transaction['status'] == 'fulfilled'): ?>
                                                <span class="badge rounded-pill bg-success px-3 py-2">Fulfilled</span>

                                            <?php elseif($transaction['status'] == 'cancelled'): ?>
                                                <span class="badge rounded-pill bg-dark px-3 py-2">Cancelled</span>

                                            <?php elseif($transaction['status'] == 'expired'): ?>
                                                <span class="badge rounded-pill bg-secondary px-3 py-2">Expired</span>

                                            <?php else: ?>
                                                <span class="badge rounded-pill bg-secondary px-3 py-2">Unknown</span>
                                            <?php endif; ?>

                                        <?php else: ?>

                                            <span class="badge rounded-pill bg-secondary px-3 py-2">N/A</span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                    <!-- PAGINATION -->
                    <div class="mt-3 d-flex justify-content-center pb-3">
                        <?= $pager->links('default', 'bootstrap_full') ?>
                    </div>

                </div>

            <?php else: ?>

                <div class="p-4 text-center text-muted">

                    <div class="mb-2 fs-5">
                        No transactions found.
                    </div>

                    <div class="small">
                        Your borrowings, requests, and reservations will appear here.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>