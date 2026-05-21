<?= $this->extend('layouts/fines_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Paid Fines
<?= $this->endSection() ?>

<?= $this->section('render_fines') ?>
<div class="p-3 card">
    <p class="fs-6 fw-bold">Borrowed Books</p>

    <?= $this->include('partials/admin/borrowed_books_filters') ?>
    <table class="table table-bordered table-hover fs-7 align-middle">

        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Borrower</th>
                <th>Book</th>
                <th>Daily Fine</th>
                <th>Total Paid</th>
                <th>Remarks</th>
                <th>Paid By</th>
                <th>Paid At</th>
                <th>Action</th>
            </tr>
        </thead>

        <tbody>

            <?php if(empty($paid_fines)): ?>

                <tr>
                    <td colspan="9" class="text-center">
                        No paid fines found.
                    </td>
                </tr>

            <?php else: ?>

                <?php foreach($paid_fines as $fine): ?>
                    <tr>

                        <td class="text-center">
                            <?= $fine['id'] ?>
                        </td>

                        <td>
                            <?= $fine['borrower_library_id'] ?>
                            <br>
                            <?= $fine['borrower_full_name'] ?>
                        </td>

                        <td>
                            <?= $fine['book_title'] ?>
                        </td>

                        <td>
                            ₱<?= $fine['daily_overdue_fine'] ?>/day
                        </td>

                        <td>
                            <strong class="text-success">
                                ₱<?= $fine['amount'] ?>
                            </strong>
                        </td>

                        <td>
                            <?= $fine['remarks'] ?>
                        </td>

                        <td>
                            <?= $fine['payer_library_id'] ?? '-' ?>
                            <br>
                            <?= $fine['payer_full_name'] ?? '-' ?>
                        </td>

                        <td>
                            <?= $fine['paid_at'] ?? '-' ?>
                        </td>

                        <td class="text-center">

                            <button type="button"
                                class="btn btn-sm btn-secondary"
                                disabled>

                                Paid
                            </button>

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
<?= $this->endSection() ?>