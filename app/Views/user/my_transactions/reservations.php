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
                <div class="fw-bold">Reservations</div>
                <div class="text-muted small">
                    Books you reserved and their queue status
                </div>
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-0">

            <?php if(!empty($reservations)): ?>

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
                                <th>Reserved Date</th>
                                <th>Queue Position</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($reservations as $reservation): ?>

                                <tr>

                                    <!-- # -->
                                    <td class="text-muted fw-semibold">
                                        <?= $i++ ?>
                                    </td>

                                    <!-- BOOK -->
                                    <td>
                                        <div class="fw-semibold">
                                            <?= esc($reservation['title']) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= esc($reservation['author']) ?>
                                        </div>
                                    </td>

                                    <!-- RESERVED DATE -->
                                    <td class="text-muted">
                                        <?= !empty($reservation['created_at'])
                                            ? date('M d, Y', strtotime($reservation['created_at']))
                                            : '-' ?>
                                    </td>

                                    <!-- QUEUE -->
                                    <td>

                                        <?php if($reservation['status'] === 'pending'): ?>

                                            <span class="badge rounded-pill bg-info text-dark px-3 py-2">
                                                #<?= esc($reservation['queue_position']) ?>
                                            </span>

                                        <?php else: ?>

                                            <span class="text-muted">
                                                —
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- STATUS -->
                                    <td>

                                        <?php if(
                                            $reservation['queue_position'] == 1 &&
                                            $reservation['status'] == 'pending' &&
                                            $reservation['availability'] == 'available'
                                        ): ?>

                                            <span class="badge rounded-pill bg-success px-3 py-2">
                                                Ready
                                            </span>

                                        <?php elseif($reservation['status'] == 'pending'): ?>

                                            <span class="badge rounded-pill bg-warning text-dark px-3 py-2">
                                                Waiting
                                            </span>

                                        <?php elseif($reservation['status'] == 'cancelled'): ?>

                                            <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                Cancelled
                                            </span>

                                        <?php elseif($reservation['status'] == 'completed'): ?>

                                            <span class="badge rounded-pill bg-primary px-3 py-2">
                                                Completed
                                            </span>

                                        <?php else: ?>

                                            <span class="badge rounded-pill bg-dark px-3 py-2">
                                                <?= ucfirst($reservation['status']) ?>
                                            </span>

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
                        No reservations found.
                    </div>

                    <div class="small">
                        Your reserved books will appear here.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>