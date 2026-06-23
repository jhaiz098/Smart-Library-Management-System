<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Overdue
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Overdue
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">
    <div class="card">
        <div class="card-header fw-bold">Overdue</div>
        <div class="card-body">
            <table class="table table-bordered table-hovered">
                <thead>
                    <tr>
                        <th>Book</th>
                        <th>Due Date</th>
                        <th>Days Overdue</th>
                        <th>Current Fine</th>
                    </tr>
                </thead>
                <tbody>

                <?php if(empty($borrowings)): ?>

                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            No overdue books.
                        </td>
                    </tr>

                <?php else: ?>

                    <?php foreach($borrowings as $borrowing): ?>

                        <tr>

                            <td>
                                <div class="fw-semibold">
                                    <?= esc($borrowing['title']) ?>
                                </div>

                                <small class="text-muted">
                                    <?= esc($borrowing['author']) ?>
                                </small>
                            </td>

                            <td>
                                <?= date('M d, Y', strtotime($borrowing['due_date'])) ?>
                            </td>

                            <td>
                                <span class="badge bg-danger">
                                    <?= $borrowing['days_overdue'] ?> day<?= $borrowing['days_overdue'] != 1 ? 's' : '' ?>
                                </span>
                            </td>

                            <td>
                                <div class="fw-bold">
                                    ₱<?= number_format($borrowing['current_fine'], 2) ?>
                                </div>

                                <small class="text-muted">
                                    ₱<?= number_format($daily_overdue_fine, 2) ?>/day
                                </small>

                                <?php if ($borrowing['is_capped']): ?>
                                    <br>
                                    <small class="text-muted">
                                        Capped at ₱<?= number_format($max_fine_amount, 2) ?>
                                    </small>
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

<?= $this->endSection() ?>