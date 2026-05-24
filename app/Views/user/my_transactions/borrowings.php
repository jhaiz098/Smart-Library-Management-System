<?= $this->extend('layouts/User/my_transactions_layout') ?>

<?= $this->section('title') ?>
    User | My Transactions
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    My Transactions
<?= $this->endSection() ?>

<?= $this->section('render_transactions') ?>

<div class="">

    <div class="card border-0">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div class="fw-bold">
                Current Borrowings
            </div>

            <span class="badge bg-primary">
                <?= count($borrowings) ?>
            </span>

        </div>

        <div class="card-body p-0">

            <?php if(!empty($borrowings)): ?>

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>
                                <th>Book</th>
                                <th>Borrowed Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th width="15%">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach($borrowings as $borrowing): ?>

                                <tr>

                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($borrowing['title']) ?>
                                        </div>

                                        <div class="small text-muted">
                                            <?= esc($borrowing['author']) ?>
                                        </div>

                                    </td>

                                    <td>

                                        <?=
                                            !empty($borrowing['borrowed_at'])
                                            ? date('M d, Y', strtotime($borrowing['borrowed_at']))
                                            : '-'
                                        ?>

                                    </td>

                                    <td>

                                        <?=
                                            !empty($borrowing['due_date'])
                                            ? date('M d, Y', strtotime($borrowing['due_date']))
                                            : '-'
                                        ?>

                                    </td>

                                    <td>

                                        <?php if($borrowing['status'] == 'borrowed'): ?>

                                            <span class="badge bg-success">
                                                Borrowed
                                            </span>

                                        <?php elseif($borrowing['status'] == 'returned'): ?>

                                            <span class="badge bg-secondary">
                                                Returned
                                            </span>

                                        <?php elseif($borrowing['status'] == 'overdue'): ?>

                                            <span class="badge bg-danger">
                                                Overdue
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-dark">
                                                <?= ucfirst($borrowing['status']) ?>
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>

                                        <a href="<?= site_url('user/books/view/' . $borrowing['book_id']) ?>"
                                            class="btn btn-sm btn-primary">

                                            View

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        </tbody>

                    </table>

                </div>

            <?php else: ?>

                <div class="p-4 text-center text-muted">

                    <div class="mb-2 fs-5">
                        No borrowings found.
                    </div>

                    <div class="small">
                        Books you borrow will appear here.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>