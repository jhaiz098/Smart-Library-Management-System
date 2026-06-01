<?= $this->extend('layouts/User/fines_layout') ?>

<?= $this->section('render_fines') ?>

<div class="">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">All Fines</div>
                <div class="text-muted small">
                    Complete history of paid, unpaid, and waived fines
                </div>
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-0">

            <?php if(!empty($fines)): ?>

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
                                <th>Book</th>
                                <th>Late By</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($fines as $fine): ?>

                                <tr>

                                    <!-- # -->
                                    <td class="text-muted fw-semibold">
                                        <?= $i++ ?>
                                    </td>

                                    <!-- BOOK -->
                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($fine['book_title']) ?>
                                        </div>

                                    </td>

                                    <!-- LATE BY -->
                                    <td>

                                        <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                            <?= esc($fine['late_by']) ?>
                                            day<?= $fine['late_by'] != 1 ? 's' : '' ?>
                                        </span>

                                    </td>

                                    <!-- AMOUNT -->
                                    <td>

                                        <div class="fw-bold">
                                            ₱<?= number_format($fine['amount'], 2) ?>
                                        </div>

                                        <?php if (
                                            !empty($fine['max_fine_amount']) &&
                                            $fine['amount'] >= $fine['max_fine_amount']
                                        ): ?>

                                            <div class="small text-muted">
                                                Max: ₱<?= number_format($fine['max_fine_amount'], 2) ?>
                                            </div>

                                        <?php endif; ?>

                                    </td>

                                    <!-- STATUS -->
                                    <td>

                                        <?php if ($fine['status'] === 'unpaid'): ?>

                                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                                Unpaid
                                            </span>

                                        <?php elseif ($fine['status'] === 'paid'): ?>

                                            <span class="badge rounded-pill bg-success px-3 py-2">
                                                Paid
                                            </span>

                                        <?php elseif ($fine['status'] === 'waived'): ?>

                                            <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                Waived
                                            </span>

                                        <?php else: ?>

                                            <span class="badge rounded-pill bg-dark px-3 py-2">
                                                <?= ucfirst($fine['status']) ?>
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- DATE -->
                                    <td class="text-muted">

                                        <?php if ($fine['status'] === 'paid'): ?>

                                            <?= !empty($fine['paid_at'])
                                                ? date('M d, Y', strtotime($fine['paid_at']))
                                                : '-' ?>

                                        <?php else: ?>

                                            <?= !empty($fine['created_at'])
                                                ? date('M d, Y', strtotime($fine['created_at']))
                                                : '-' ?>

                                        <?php endif; ?>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

                <!-- PAGINATION -->
                <div class="p-3 d-flex justify-content-center">
                    <?= $pager->links('default', 'bootstrap_full') ?>
                </div>

            <?php else: ?>

                <!-- EMPTY STATE -->
                <div class="text-center p-5">

                    <div class="mb-2 fs-5 fw-semibold text-muted">
                        No fines found
                    </div>

                    <div class="text-muted small">
                        Fine records will appear here when penalties are generated.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>