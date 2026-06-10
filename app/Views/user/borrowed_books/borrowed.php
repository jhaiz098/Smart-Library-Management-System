<?= $this->extend('layouts/User/borrowed_books') ?>

<?= $this->section('render_borrows') ?>

<div class="">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <div>
                <div class="fw-bold">Borrowed Books</div>
                <div class="text-muted small">
                    Books currently checked out and awaiting return
                </div>
            </div>

        </div>

        <!-- BODY -->
        <div class="card-body p-0">

            <?php if(!empty($borrowed_books)): ?>

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
                                <th>Borrowing Code</th>
                                <th>Book</th>
                                <th>Borrow Date</th>
                                <th>Due Date</th>
                                <th>Status</th>
                                <th>Issued By</th>
                            </tr>

                        </thead>

                        <tbody>

                            <?php foreach ($borrowed_books as $book): ?>

                                <tr>

                                    <!-- # -->
                                    <td class="text-muted fw-semibold">
                                        <?= $i++ ?>
                                    </td>

                                    <td>
                                        <span class="badge bg-dark rounded-pill px-3 py-2">
                                            <?= $book['borrowing_code'] ?>
                                        </span>
                                    </td>

                                    <!-- BOOK -->
                                    <td>
                                        <div>
                                            <?= esc($book['title']) ?>
                                        </div>

                                        <div class="small text-muted">

                                            <?php
                                                $description = strip_tags($book['description']);
                                                echo strlen($description) > 60
                                                    ? substr($description, 0, 60) . '...'
                                                    : $description;
                                            ?>

                                        </div>
                                    </td>

                                    <!-- BORROW DATE -->
                                    <td>
                                        <?= date('F d, Y', strtotime($book['borrow_date'])) ?>
                                    </td>

                                    <!-- DUE DATE -->
                                    <td>
                                        <?= date('F d, Y', strtotime($book['due_date'])) ?>
                                    </td>

                                    <!-- STATUS -->
                                    <td>

                                        <?php if($book['status'] === 'returned'): ?>

                                            <?php if (
                                                !empty($book['return_date']) &&
                                                strtotime($book['return_date']) > strtotime($book['due_date'])
                                            ): ?>

                                                <span class="badge bg-danger rounded-pill px-3 py-2">
                                                    Returned Late
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-success rounded-pill px-3 py-2">
                                                    Returned On Time
                                                </span>

                                            <?php endif; ?>

                                        <?php elseif($book['status_label'] === 'Overdue'): ?>

                                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                                Overdue
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-primary rounded-pill px-3 py-2">
                                                Borrowed
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <!-- ISSUED BY -->
                                    <td>
                                        <div>
                                            <?= esc($book['issuer_fullname']) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= esc($book['issuer_library_id']) ?>
                                        </div>
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

                    <div class="mb-2 fs-5 fw-semibold text-secondary">
                        No borrowing records
                    </div>

                    <div class="text-muted small">
                        Your borrowing history will appear here once you borrow a book.
                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>