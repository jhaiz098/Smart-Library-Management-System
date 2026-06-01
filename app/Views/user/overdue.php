<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Overdue
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Overdue
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="py-0 px-3">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">Overdue Books</div>
                <div class="text-muted small">
                    Borrowed books that have passed their due date and accumulated fines
                </div>
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-0">

            <?php if(!empty($borrowings)): ?>

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
                                <th>Due Date</th>
                                <th>Days Overdue</th>
                                <th>Current Fine</th>
                            </tr>

                        </thead>

                        <tbody>

                        <?php foreach($borrowings as $borrowing): ?>

                            <tr>

                                <!-- # -->
                                <td class="text-muted fw-semibold">
                                    <?= $i++ ?>
                                </td>

                                <!-- BOOK -->
                                <td>
                                    <div class="fw-semibold">
                                        <?= esc($borrowing['title']) ?>
                                    </div>

                                    <div class="small text-muted">
                                        <?= esc($borrowing['author']) ?>
                                    </div>
                                </td>

                                <!-- DUE DATE -->
                                <td class="text-muted">
                                    <?= date('M d, Y', strtotime($borrowing['due_date'])) ?>
                                </td>

                                <!-- DAYS OVERDUE -->
                                <td>
                                    <span class="badge rounded-pill bg-danger px-3 py-2">
                                        <?= $borrowing['days_overdue'] ?>
                                        day<?= $borrowing['days_overdue'] != 1 ? 's' : '' ?>
                                    </span>
                                </td>

                                <!-- FINE -->
                                <td>

                                    <div class="fw-bold text-danger">
                                        ₱<?= number_format($borrowing['current_fine'], 2) ?>
                                    </div>

                                    <div class="small text-muted">
                                        ₱<?= number_format($daily_overdue_fine, 2) ?>/day
                                    </div>

                                    <?php if ($borrowing['is_capped']): ?>

                                        <div class="small text-muted">
                                            Max: ₱<?= number_format($max_fine_amount, 2) ?>
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
                        No overdue books
                    </div>

                    <div class="text-muted small">
                        Great! All borrowed books are within their due dates.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>