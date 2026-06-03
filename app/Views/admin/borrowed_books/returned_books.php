<?= $this->extend('layouts/borrowed_books_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Returned Books
<?= $this->endSection() ?>


<?= $this->section('render_borrowed') ?>

<div class="border-0 shadow-sm">

    <!-- FILTERS -->
    <?= $this->include('partials/admin/borrowed_books_filters') ?>

    <!-- TABLE -->
    <div class="table-responsive rounded-3 border bg-white shadow-sm">

        <table class="table table-hover align-middle mb-0">

            <thead class="bg-light border-bottom align-middle">
                <tr class="text-muted small text-uppercase">
                    <th>#</th>
                    <th>Borrower</th>
                    <th>Book</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th>Issued By</th>
                    <th>Status</th>
                    <th>Fine</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if(empty($returned_books)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted py-4">
                            No returned books found
                        </td>
                    </tr>
                <?php else: ?>

                    <?php $i = 1; foreach($returned_books as $rb): ?>

                        <tr>

                            <!-- ROW # -->
                            <td class="text-muted fw-semibold text-center">
                                <?= $i++ ?>
                            </td>

                            <!-- BORROWER -->
                            <td>
                                <div class="fw-semibold">
                                    <?= esc($rb['borrower_name']) ?>
                                </div>
                                <div class="text-muted small">
                                    <?= esc($rb['borrower_library_id']) ?>
                                </div>
                            </td>

                            <!-- BOOK -->
                            <td class="fw-semibold">
                                <?= esc($rb['book_title']) ?>
                            </td>

                            <!-- BORROW DATE -->
                            <td class="text-muted">
                                <?= date('F d, Y', strtotime($rb['borrow_date'])) ?>
                            </td>

                            <!-- DUE DATE -->
                            <td class="text-muted">
                                <?= date('F d, Y', strtotime($rb['due_date'])) ?>
                            </td>

                            <!-- ISSUED BY -->
                            <td>
                                <div class="small">
                                    <?= esc($rb['issued_by_name']) ?>
                                </div>
                                <div class="text-muted small">
                                    <?= esc($rb['issued_by_library_id']) ?>
                                </div>
                            </td>

                            <!-- STATUS -->
                            <td class="text-center">

                                <?php if (
                                    !empty($rb['return_date']) &&
                                    strtotime($rb['return_date']) > strtotime($rb['due_date'])
                                ): ?>

                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        Returned Late
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        Returned On Time
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- FINE -->
                            <td class="text-center">

                                <?php if (!empty($rb['fine_amount']) && $rb['fine_amount'] > 0): ?>
                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        ₱<?= number_format($rb['fine_amount'], 2) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">—</span>
                                <?php endif; ?>

                            </td>

                            <!-- ACTIONS DROPDOWN -->
                            <td class="text-center">

                                <div class="dropdown">

                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                            data-bs-toggle="dropdown">
                                        Actions
                                    </button>

                                    <ul class="dropdown-menu">

                                        <li>
                                            <button class="dropdown-item text-primary">
                                                View Details
                                            </button>
                                        </li>

                                        <li>
                                            <button class="dropdown-item text-dark">
                                                View History
                                            </button>
                                        </li>

                                    </ul>

                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php endif; ?>

            </tbody>

        </table>

    </div>

    <!-- PAGINATION -->
    <div class="mt-3 d-flex justify-content-center">
        <?= $pager->links('default', 'bootstrap_full') ?>
    </div>

</div>

<?= $this->endSection() ?>