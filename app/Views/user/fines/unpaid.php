<?= $this->extend('layouts/User/fines_layout') ?>

<?= $this->section('render_fines') ?>

<div class="">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">Unpaid Fines</div>
                <div class="text-muted small">
                    Outstanding penalties that still require payment
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
                                <th>Fine Ref</th>
                                <th>Book</th>
                                <th>Late By</th>
                                <th>Rate</th>
                                <th>Amount</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($fines as $fine): ?>

                                <tr>

                                    <!-- # -->
                                    <td class="text-muted fw-semibold">
                                        <?= $i++ ?>
                                    </td>

                                    <!-- FINE REF -->
                                    <td>
                                        <span class="badge bg-light text-dark border px-3 py-2">
                                            <?= esc($fine['fine_ref']) ?>
                                        </span>
                                    </td>

                                    <!-- BOOK -->
                                    <td>
                                        <div class="fw-semibold">
                                            <?= esc($fine['book_title']) ?>
                                        </div>
                                    </td>

                                    <!-- LATE BY -->
                                    <td>
                                        <span class="badge rounded-pill bg-danger px-3 py-2">
                                            <?= esc($fine['late_by']) ?>
                                        </span>
                                    </td>

                                    <!-- RATE -->
                                    <td class="text-muted">
                                        ₱<?= number_format($fine['daily_overdue_fine'], 2) ?>/day
                                    </td>

                                    <!-- AMOUNT -->
                                    <td>

                                        <div class="fw-bold text-danger">
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

                    <div class="mb-2 fs-5 fw-semibold text-success">
                        No unpaid fines
                    </div>

                    <div class="text-muted small">
                        Great! You currently have no outstanding penalties.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>