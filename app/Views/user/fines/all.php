<?= $this->extend('layouts/User/fines_layout') ?>



<?= $this->section('render_fines') ?>

<div class="">

    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div class="fw-bold">
                All Fines
            </div>

            <span class="badge bg-primary">
                <?= count($fines) ?>
            </span>

        </div>

        <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover table-bordered align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <tr>
                                    <th>Book</th>
                                    <th>Late By</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                </tr>
                            </tr>

                        </thead>

                        <tbody>
                            <?php if(empty($fines)): ?>
                                <tr>
                                    <td colspan="10" class="text-center">No fines found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($fines as $fine): ?>

                                <tr>

                                    <td>
                                        <?= esc($fine['book_title']) ?>
                                    </td>

                                    <td>
                                        <?= esc($fine['late_by']) ?>
                                    </td>

                                    <td>
                                        <div class="fw-bold">
                                            ₱<?= number_format($fine['amount'], 2) ?>
                                        </div>

                                        <?php if (
                                            !empty($fine['max_fine_amount']) &&
                                            $fine['amount'] >= $fine['max_fine_amount']
                                        ): ?>
                                            <small class="text-muted">
                                                Capped at ₱<?= number_format($fine['max_fine_amount'], 2) ?>
                                            </small>
                                        <?php endif; ?>
                                    </td>

                                    <td>

                                        <?php if ($fine['status'] === 'unpaid'): ?>

                                            <span class="badge bg-warning text-dark">
                                                Unpaid
                                            </span>

                                        <?php elseif ($fine['status'] === 'paid'): ?>

                                            <span class="badge bg-success">
                                                Paid
                                            </span>

                                        <?php elseif ($fine['status'] === 'waived'): ?>

                                            <span class="badge bg-secondary">
                                                Waived
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-dark">
                                                <?= ucfirst($fine['status']) ?>
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>
                                        <?php if ($fine['status'] === 'paid'): ?>
                                            <?= !empty($fine['paid_at']) ? date('M d, Y', strtotime($fine['paid_at'])) : '-' ?>
                                        <?php else: ?>
                                            <?= !empty($fine['created_at']) ? date('M d, Y', strtotime($fine['created_at'])) : '-' ?>
                                        <?php endif; ?>
                                    </td>

                                </tr>

                                <?php endforeach; ?>
                            <?php endif; ?>

                        </tbody>

                    </table>
                    
                    <div class="mt-3 d-flex justify-content-center">
                        <?= $pager->links('default', 'bootstrap_full') ?>
                    </div>
                </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>