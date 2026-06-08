<?= $this->extend('layouts/User/my_transactions_layout') ?>

<?= $this->section('title') ?>
    User | My Transactions
<?= $this->endSection() ?>

<?= $this->section('render_transactions') ?>

<div class="py-0">

    <div class="card border-0 shadow-sm">

        <!-- HEADER (IMPROVED LIKE BORROWINGS STYLE) -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">Borrow Requests</div>
                <div class="text-muted small">
                    Books you requested for borrowing and their approval status
                </div>
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-0">

            <?php if(!empty($borrow_requests)): ?>

                <?php
                    $perPage = $pager->getPerPage('default');
                    $page = $pager->getCurrentPage('default');
                    $i = ($page - 1) * $perPage + 1;
                ?>

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0 fs-7">

                        <thead class="table-light text-uppercase">

                            <tr>
                                <th>#</th>
                                <th>Request Code</th>
                                <th>Book</th>
                                <th>Request Date</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>
                            <?php if(empty($borrow_requests)): ?>

                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No borrow requests recorded
                                    </td>
                                </tr>

                            <?php else: ?>

                                <?php foreach($borrow_requests as $request): ?>

                                    <tr>

                                        <!-- # -->
                                        <td>
                                            <?= $i++ ?>
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill bg-dark px-3 py-2">
                                                <?= ucfirst($request['borrow_request_code']) ?>
                                            </span>
                                        </td>

                                        <!-- BOOK -->
                                        <td>

                                            <div>
                                                <?= esc($request['title']) ?>
                                            </div>

                                            <div class="small text-muted">

                                                <?php
                                                    $description = strip_tags($request['description']);
                                                    echo strlen($description) > 60
                                                        ? substr($description, 0, 60) . '...'
                                                        : $description;
                                                ?>

                                            </div>

                                        </td>

                                        <!-- REQUEST DATE -->
                                        <td>

                                            <?= 
                                                !empty($request['created_at'])
                                                ? date('M d, Y', strtotime($request['created_at']))
                                                : '-'
                                            ?>

                                        </td>

                                        <!-- STATUS (ALL ROUNDED PILLS) -->
                                        <td>

                                            <?php if($request['status'] == 'pending'): ?>

                                                <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                                    Pending
                                                </span>

                                            <?php elseif($request['status'] == 'approved'): ?>

                                                <span class="badge rounded-pill bg-success px-3 py-2">
                                                    Approved
                                                </span>

                                            <?php elseif($request['status'] == 'rejected'): ?>

                                                <span class="badge rounded-pill bg-danger px-3 py-2">
                                                    Rejected
                                                </span>

                                            <?php elseif($request['status'] == 'cancelled'): ?>

                                                <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                    Cancelled
                                                </span>

                                            <?php else: ?>

                                                <span class="badge rounded-pill bg-dark px-3 py-2">
                                                    <?= ucfirst($request['status']) ?>
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>

                    </table>

                    <!-- PAGINATION -->
                    <div class="p-3 d-flex justify-content-center">
                        <?= $pager->links('default', 'bootstrap_full') ?>
                    </div>

                </div>

            <?php else: ?>

                <!-- EMPTY STATE -->
                <div class="text-center p-5">

                    <div class="mb-2 fs-5 fw-semibold text-muted">
                        No borrow requests found
                    </div>

                    <div class="text-muted small">
                        Your borrow requests will appear here once you submit one.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>