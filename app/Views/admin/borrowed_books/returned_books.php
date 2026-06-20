<?= $this->extend('layouts/borrowed_books_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Returned Books
<?= $this->endSection() ?>


<?= $this->section('render_borrowed') ?>
            <div class="p-3 card">
                <p class="fs-6 fw-bold">Returned Books</p>

                <?= $this->include('partials/admin/borrowed_books_filters') ?>

                <table class="table table-bordered table-hover fs-7 align-middle">
                    <thead class="text-center">
                        <tr>
                            <th>ID</th>
                            <th>Borrower</th>
                            <th>Book</th>
                            <th>Borrow Date</th>
                            <th>Due Date</th>
                            <th>Issued By</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($returned_books)): ?>

                            <tr>
                                <td colspan="8" class="text-center">
                                    No borrowed books found.
                                </td>
                            </tr>

                        <?php else: ?>
                            <?php foreach($returned_books as $rb): ?>
                                <tr>
                                    <td class="text-center">
                                        <?= $rb['id'] ?>
                                    </td>

                                    <td>
                                        <?= $rb['borrower_library_id'] ?>
                                        <br>
                                        <?= $rb['borrower_name'] ?>
                                    </td>

                                    <td>
                                        <?= $rb['book_title'] ?>
                                    </td>

                                    <td>
                                        <?= $rb['borrow_date'] ?>
                                    </td>

                                    <td>
                                        <?= $rb['due_date'] ?>
                                    </td>

                                    <td>
                                        <?= $rb['issued_by_library_id'] ?>
                                        <br>
                                        <?= $rb['issued_by_name'] ?>
                                    </td>

                                    <td class="text-center">

                                        <?php if (
                                            !empty($rb['return_date']) &&
                                            strtotime($rb['return_date']) > strtotime($rb['due_date'])
                                        ): ?>

                                            <span class="badge bg-danger">
                                                Returned Late
                                            </span>

                                        <?php else: ?>

                                            <span class="badge bg-success">
                                                Returned On Time
                                            </span>

                                        <?php endif; ?>

                                    </td>
                                    
                                    <td class="text-center">
                                        <?php if (!empty($rb['fine_amount']) && $rb['fine_amount'] > 0): ?>
                                            <span class="badge bg-danger">
                                                ₱<?= number_format($rb['fine_amount'], 2) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="text-muted">—</span>
                                        <?php endif; ?>
                                    </td>

                                    <td>
                                        <button class="btn btn-sm btn-secondary">View Details</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <div class="mt-3 d-flex justify-content-center">
                <?= $pager->links('default', 'bootstrap_full') ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>