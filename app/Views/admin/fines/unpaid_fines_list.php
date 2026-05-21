<?= $this->extend('layouts/fines_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Unpaid Fines
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
                <th>Total Amount</th>
                <th>Remarks</th>
                <th>Issued By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($unpaid_fines)): ?>

                <tr>
                    <td colspan="8" class="text-center">
                        No borrowed books found.
                    </td>
                </tr>

            <?php else: ?>
                <?php foreach($unpaid_fines as $bb): ?>
                    <tr>
                        <td class="text-center">
                            <?= $bb['id'] ?>
                        </td>

                        <td>
                            <?= $bb['borrower_library_id'] ?>
                            <br>
                            <?= $bb['borrower_full_name'] ?>
                        </td>

                        <td>
                            <?= $bb['book_title'] ?>
                        </td>

                        <td>
                            ₱<?= $bb['daily_overdue_fine'] ?>/day
                        </td>
                        
                        <td>
                            ₱<?= $bb['amount'] ?>
                        </td>

                        <td>
                            <?= $bb['remarks'] ?>
                        </td>

                        <td>
                            <?= $bb['issuer_library_id'] ?>
                            <br>
                            <?= $bb['issuer_full_name'] ?>
                        </td>

                        <td>
                            <button type="button" 
                                class="btn btn-sm btn-success"

                                data-bs-toggle="modal"
                                data-bs-target="#paymentModal"

                                data-id="<?= $bb['id'] ?>"
                                data-user="<?= $bb['borrower_full_name'] ?>"
                                data-book="<?= $bb['book_title'] ?>"

                                data-daily-fine="<?= $bb['daily_overdue_fine'] ?>"
                                data-days-late="<?= $bb['days_late'] ?>"
                                data-total="<?= $bb['amount'] ?>"
                                data-max-fine="<?= $bb['max_fine_amount'] ?>">

                                Record Payment
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

<div class="modal fade" id="paymentModal" tabindex="-1">

    <div class="modal-dialog">

        <div class="modal-content">

            <form method="post"
                action="<?= base_url('admin/unpaid_fines_list/pay_fine') ?>">

                <input type="hidden"
                    name="fine_id"
                    id="payment_fine_id">

                <div class="modal-header">

                    <h5 class="modal-title">
                        Record Fine Payment
                    </h5>

                    <button 
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="alert alert-warning">

                        Please confirm that the borrower has paid the fine.

                    </div>

                    <table class="table table-bordered">

                        <tr>
                            <th>Borrower</th>
                            <td id="payment_user"></td>
                        </tr>

                        <tr>
                            <th>Book</th>
                            <td id="payment_book"></td>
                        </tr>

                        <tr>
                            <th>Fine Rate</th>
                            <td id="payment_daily_fine"></td>
                        </tr>

                        <tr>
                            <th>Days Late</th>
                            <td id="payment_days_late"></td>
                        </tr>

                        <tr>
                            <th>Total Fine</th>
                            <td id="payment_total"></td>
                        </tr>

                    </table>

                    <div id="max_fine_notice"></div>

                    <div class="mb-3">

                        <label class="form-label">
                            Payment Remarks (Optional)
                        </label>

                        <textarea 
                            name="remarks"
                            class="form-control"
                            rows="3"
                            placeholder="Example: Paid in cash"></textarea>

                    </div>

                </div>

                <div class="modal-footer">

                    <button 
                        type="button"
                        class="btn btn-secondary"
                        data-bs-dismiss="modal">
                        Cancel
                    </button>

                    <button 
                        type="submit"
                        class="btn btn-success">
                        Confirm Payment
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const paymentModal = document.getElementById('paymentModal');

    paymentModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');

        const user = button.getAttribute('data-user');
        const book = button.getAttribute('data-book');

        const dailyFine = parseFloat(
            button.getAttribute('data-daily-fine') || 0
        );

        const daysLate = parseInt(
            button.getAttribute('data-days-late') || 0
        );

        const total = parseFloat(
            button.getAttribute('data-total') || 0
        );
        
        const uncappedTotal = dailyFine * daysLate;

        const maxFine = parseFloat(
            button.getAttribute('data-max-fine') || 0
        );

        const cappedTotal = maxFine > 0
            ? Math.min(uncappedTotal, maxFine)
            : uncappedTotal;

        // HIDDEN INPUT
        document.getElementById('payment_fine_id').value = id;

        // BASIC INFO
        document.getElementById('payment_user').innerText = user;

        document.getElementById('payment_book').innerText = book;

        // FINE INFO
        document.getElementById('payment_daily_fine').innerText =
            `₱${dailyFine} per day`;

        document.getElementById('payment_days_late').innerText =
            `${daysLate} day(s)`;

        document.getElementById('payment_total').innerHTML = `
            <div class="border rounded p-2 bg-light">

                <div class="mb-1">
                    <strong>Computation</strong>
                </div>

                <div>
                    ₱${dailyFine} × ${daysLate} day(s)
                </div>

                <div>
                    Uncapped Total: <strong>₱${uncappedTotal}</strong>
                </div>

                <hr class="my-2">

                <div>
                    Max Fine Limit: ₱${maxFine}
                </div>

                <div>
                    Final Charge: <strong class="text-success">₱${cappedTotal}</strong>
                </div>

            </div>
        `;

        // MAX FINE NOTICE
        const maxFineNotice =
            document.getElementById('max_fine_notice');

        maxFineNotice.innerHTML = '';

        if (total >= maxFine) {

            maxFineNotice.innerHTML = `
                <div class="alert alert-danger">

                    <strong>
                        Maximum fine amount reached.
                    </strong>

                    <br>

                    Max Fine Amount:
                    ₱${maxFine}

                </div>
            `;
        }

    });

});
</script>
<?= $this->endSection() ?>