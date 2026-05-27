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
                All Transactions
            </div>

            <span class="badge bg-primary">
                <?= count($transactions) ?>
            </span>

        </div>

        <div class="card-body p-0">

            <?php if(!empty($transactions)): ?>

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Book</th>
                                <th>Type</th>
                                <th>Date</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($transactions as $transaction): ?>

                                <tr>

                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($transaction['title']) ?>
                                        </div>

                                        <div class="small text-muted">
                                            <?= esc($transaction['author']) ?>
                                        </div>

                                    </td>

                                    <td>

                                        <?php if($transaction['transaction_type'] == 'borrowing'): ?>

                                            <span class="badge bg-success">
                                                Borrowing
                                            </span>

                                        <?php elseif($transaction['transaction_type'] == 'borrow_request'): ?>

                                            <span class="badge bg-primary">
                                                Borrow Request
                                            </span>

                                        <?php elseif($transaction['transaction_type'] == 'reservation'): ?>

                                            <span class="badge bg-warning text-dark">
                                                Reservation
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-dark">
                                                <?= ucfirst($transaction['transaction_type']) ?>
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <?= 
                                            !empty($transaction['created_at'])
                                            ? date('M d, Y', strtotime($transaction['created_at']))
                                            : '-'
                                        ?>

                                    </td>

                                    <td>
                                        <?php $status = $transaction['status'] ?? null; ?>

                                        <?php if($transaction['transaction_type'] == 'borrowing'): ?>
                                            <?php if($transaction['status'] == 'borrowed'): ?>
                                                <span class="badge bg-primary">Borrowed</span>

                                            <?php elseif($transaction['status'] == 'returned'): ?>
                                                <span class="badge bg-success">Returned</span>
                                            <?php endif; ?>
                                        <?php elseif($transaction['transaction_type'] == 'borrow_request'): ?>

                                            <?php if($transaction['status'] == 'pending'): ?>
                                                <span class="badge bg-warning text-dark">Pending</span>

                                            <?php elseif($transaction['status'] == 'approved'): ?>
                                                <span class="badge bg-info text-dark">Approved</span>

                                            <?php elseif($transaction['status'] == 'claimed'): ?>
                                                <span class="badge bg-success">Claimed</span>

                                            <?php elseif($transaction['status'] == 'rejected'): ?>
                                                <span class="badge bg-danger">Rejected</span>

                                            <?php elseif($transaction['status'] == 'expired'): ?>
                                                <span class="badge bg-secondary">Expired</span>

                                            <?php elseif($transaction['status'] == 'cancelled'): ?>
                                                <span class="badge bg-dark">Cancelled</span>

                                            <?php else: ?>
                                                <span class="badge bg-secondary">Unknown</span>
                                            <?php endif; ?>

                                        <?php elseif($transaction['transaction_type'] == 'reservation'): ?>

                                            <?php if($transaction['status'] == 'pending'): ?>
                                                <span class="badge bg-warning text-dark">Waiting</span>

                                            <?php elseif($transaction['status'] == 'fulfilled'): ?>
                                                <span class="badge bg-success">Fulfilled</span>

                                            <?php elseif($transaction['status'] == 'cancelled'): ?>
                                                <span class="badge bg-dark">Cancelled</span>

                                            <?php elseif($transaction['status'] == 'expired'): ?>
                                                <span class="badge bg-secondary">Expired</span>

                                            <?php else: ?>
                                                <span class="badge bg-secondary">Unknown</span>
                                            <?php endif; ?>

                                        <?php else: ?>

                                            <span class="badge bg-secondary">N/A</span>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>
                    <div class="mt-3 d-flex justify-content-center">
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