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
                Reservations
            </div>

            <span class="badge bg-primary">
                <?= count($reservations) ?>
            </span>

        </div>

        <div class="card-body p-0">

            <?php if(!empty($reservations)): ?>

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Book</th>
                                <th>Reserved Date</th>
                                <th>Queue Position</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($reservations as $reservation): ?>

                                <tr>

                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($reservation['title']) ?>
                                        </div>

                                        <div class="small text-muted">
                                            <?= esc($reservation['author']) ?>
                                        </div>

                                    </td>

                                    <td>

                                        <?= 
                                            !empty($reservation['created_at'])
                                            ? date('M d, Y', strtotime($reservation['created_at']))
                                            : '-'
                                        ?>

                                    </td>

                                    <td>

                                        <span class="badge bg-info text-dark">
                                            #<?= esc($reservation['queue_position']) ?>
                                        </span>

                                    </td>

                                    <td>
                                        <?php if(
                                            $reservation['queue_position'] == 1 &&
                                            $reservation['status'] == 'pending' &&
                                            $reservation['availability'] == 'available'
                                        ): ?>

                                            <span class="badge bg-success">
                                                Ready
                                            </span>

                                        <?php elseif($reservation['status'] == 'pending'): ?>

                                            <span class="badge bg-warning text-dark">
                                                Waiting
                                            </span>

                                        <?php elseif($reservation['status'] == 'cancelled'): ?>

                                            <span class="badge bg-secondary">
                                                Cancelled
                                            </span>

                                        <?php elseif($reservation['status'] == 'completed'): ?>

                                            <span class="badge bg-primary">
                                                Completed
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-dark">
                                                <?= ucfirst($reservation['status']) ?>
                                            </span>

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