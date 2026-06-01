<?= $this->extend('layouts/User/fines_layout') ?>

<?= $this->section('render_fines') ?>

<div class="">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">Paid Fines</div>
                <div class="text-muted small">
                    Fine payments that have already been settled
                </div>
            </div>

            <div class="text-end">
                <div class="fw-semibold text-success">
                    <?= count($fines) ?>
                </div>
                <div class="text-muted small">
                    Paid Records
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
                                <th>Rate</th>
                                <th>Amount Paid</th>
                                <th>Paid On</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($fines as $fine): ?>

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

                                    <!-- RATE -->
                                    <td class="text-muted">

                                        ₱<?= number_format($fine['daily_overdue_fine'], 2) ?>/day

                                    </td>

                                    <!-- AMOUNT -->
                                    <td>

                                        <div class="fw-bold text-success">
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

                                    <!-- PAID DATE -->
                                    <td class="text-muted">

                                        <?= !empty($fine['paid_at'])
                                            ? date('M d, Y', strtotime($fine['paid_at']))
                                            : '-' ?>

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
                        No paid fines found
                    </div>

                    <div class="text-muted small">
                        Paid fine records will appear here once payments are made.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>