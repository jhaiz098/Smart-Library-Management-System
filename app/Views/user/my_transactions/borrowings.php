<?= $this->extend('layouts/User/my_transactions_layout') ?>

<?= $this->section('title') ?>
User | My Transactions
<?= $this->endSection() ?>

<?= $this->section('render_transactions') ?>

<div class="py-0">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">Current Borrowings</div>
                <div class="text-muted small">
                    Books you currently borrowed and their due dates
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

                    <table class="table table-hover align-middle mb-0 fs-7">

                        <thead class="table-light text-uppercase">

                            <tr>
                                <th>#</th>
                                <th>Borrowing Code</th>
                                <th>Book</th>
                                <th>Borrowed</th>
                                <th>Due Date</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>
                            <?php if(empty($borrowings)): ?>

                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">
                                        No borrowings recorded
                                    </td>
                                </tr>

                            <?php else: ?>

                                <?php foreach($borrowings as $borrowing): ?>

                                    <tr>

                                        <!-- # -->
                                        <td>
                                            <?= $i++ ?>
                                        </td>

                                        <td>
                                            <span class="badge rounded-pill bg-dark px-3 py-2">
                                                <?= esc($borrowing['borrowing_code']) ?>
                                            </span>
                                        </td>

                                        <!-- BOOK -->
                                        <td>
                                            <div>
                                                <?= esc($borrowing['title']) ?>
                                            </div>

                                            <div class="small text-muted">

                                                <?php
                                                    $description = strip_tags($borrowing['description']);
                                                    echo strlen($description) > 60
                                                        ? substr($description, 0, 60) . '...'
                                                        : $description;
                                                ?>

                                            </div>
                                        </td>

                                        <!-- BORROW DATE -->
                                        <td>
                                            <?= !empty($borrowing['borrow_date'])
                                                ? date('M d, Y', strtotime($borrowing['borrow_date']))
                                                : '-' ?>
                                        </td>

                                        <!-- DUE DATE -->
                                        <td>
                                            <?= !empty($borrowing['due_date'])
                                                ? date('M d, Y', strtotime($borrowing['due_date']))
                                                : '-' ?>
                                        </td>

                                        <!-- STATUS -->
                                        <td>

                                            <?php if(
                                                $borrowing['status'] == 'borrowed' &&
                                                strtotime($borrowing['due_date']) < time()
                                            ): ?>

                                                <span class="badge rounded-pill bg-danger px-3 py-2">
                                                    Overdue
                                                </span>

                                            <?php elseif($borrowing['status'] == 'borrowed'): ?>

                                                <span class="badge rounded-pill bg-success px-3 py-2">
                                                    Borrowed
                                                </span>

                                            <?php elseif($borrowing['status'] == 'returned'): ?>

                                                <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                    Returned
                                                </span>

                                            <?php else: ?>

                                                <span class="badge rounded-pill bg-dark px-3 py-2">
                                                    <?= ucfirst($borrowing['status']) ?>
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                <?php endforeach; ?>
                            <?php endif; ?>

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
                        No borrowings found
                    </div>

                    <div class="text-muted small">
                        Books you borrow will appear here once you start borrowing.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>