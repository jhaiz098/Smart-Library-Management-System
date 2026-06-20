<?= $this->extend('layouts/borrowed_books_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Borrowed Books
<?= $this->endSection() ?>


<?= $this->section('render_borrowed') ?>
<div class="p-3 card">
    <p class="fs-6 fw-bold">Borrowed Books</p>

    <?= $this->include('partials/admin/borrowed_books_filters') ?>
    <table class="table table-bordered table-hover fs-7 align-middle">
        <thead class="text-center">
            <tr>
                <th>ID</th>
                <th>Borrower</th>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Status</th>
                <th>Issued By</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if(empty($borrowed_books)): ?>

                <tr>
                    <td colspan="8" class="text-center">
                        No borrowed books found.
                    </td>
                </tr>

            <?php else: ?>
                <?php foreach($borrowed_books as $bb): ?>
                    <tr>
                        <td class="text-center">
                            <?= $bb['id'] ?>
                        </td>

                        <td>
                            <?= $bb['borrower_library_id'] ?>
                            <br>
                            <?= $bb['borrower_name'] ?>
                        </td>

                        <td>
                            <?= $bb['book_title'] ?>
                        </td>

                        <td>
                            <?= $bb['borrow_date'] ?>
                        </td>

                        <td>
                            <?= $bb['due_date'] ?>
                        </td>

                        <td>
                            <?php if($bb['status_label'] === 'Overdue'): ?>
                                <span class="badge bg-danger">
                                    Overdue
                                </span>
                            <?php else: ?>
                                <span class="badge bg-primary">
                                    Borrowed
                                </span>
                            <?php endif; ?>
                        </td>

                        <td>
                            <?= $bb['issued_by_library_id'] ?>
                            <br>
                            <?= $bb['issued_by_name'] ?>
                        </td>

                        <td>
                            <button type="button" 
                                class="btn btn-sm btn-success"

                                data-bs-toggle="modal"
                                data-bs-target="#returnModal"

                                data-id="<?= $bb['id'] ?>"
                                data-user="<?= $bb['borrower_name'] ?>"
                                data-book="<?= $bb['book_title'] ?>"
                                data-due="<?= $bb['due_date'] ?>"
                                data-daily_overdue_fine="<?= $daily_overdue_fine ?>"
                                >

                                Return
                            </button>
                        </td>

                        <td>
                            <button type="button" 
                                class="btn btn-sm btn-primary"

                                data-bs-toggle="modal"
                                data-bs-target="#extendModal"

                                data-id="<?= $bb['id'] ?>"
                                data-user="<?= $bb['borrower_name'] ?>"
                                data-book="<?= $bb['book_title'] ?>"
                                data-due="<?= $bb['due_date'] ?>">

                                Extend Due Date
                            </button>
                        </td>

                        <td>
                            <button type="button" 
                                class="btn btn-sm btn-dark"

                                data-bs-toggle="modal"
                                data-bs-target="#historyModal"

                                data-id="<?= $bb['id'] ?>"
                                data-user="<?= $bb['borrower_name'] ?>"
                                data-book="<?= $bb['book_title'] ?>">

                                View History
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



<div class="modal fade" id="returnModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            
            <form method="post" action="<?= base_url('admin/borrowed_books/return') ?>">
                
                <input type="hidden"
                        name="borrowing_id"
                        id="return_id">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Confirm Book Return
                    </h5>

                    <button 
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <p>
                        Are you sure this book has been returned?
                    </p>

                    <table class="table table-bordered">
                        <tr>
                            <th>Borrower</th>
                            <td id="return_user"></td>
                        </tr>

                        <tr>
                            <th>Book</th>
                            <td id="return_book"></td>
                        </tr>
                    </table>
                    
                    <div id="fine_notice"></div>

                    <div class="mb-3">
                        <label class="form-label">
                            Remarks (Optional)
                        </label>

                        <textarea 
                            name="remarks"
                            class="form-control"></textarea>
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
                        Confirm Return
                    </button>

                </div>

            </form>
                                
        </div>
    </div>
</div>

<div class="modal fade" id="extendModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">

            <form method="post" action="<?= base_url('admin/borrowed_books/extend') ?>">
                
                <input type="hidden"
                        name="borrowing_id"
                        id="extend_id">

                <div class="modal-header">
                    <h5 class="modal-title">
                        Extend Due Date
                    </h5>

                    <button 
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">
                        <tr>
                            <th>Borrower</th>
                            <td id="extend_user"></td>
                        </tr>

                        <tr>
                            <th>Book</th>
                            <td id="extend_book"></td>
                        </tr>

                        <tr>
                            <th>Current Due Date</th>
                            <td id="extend_due"></td>
                        </tr>
                    </table>

                    <div class="mb-3">

                        <label class="form-label">
                            Extend By
                        </label>

                        <select 
                            name="extend_days"
                            class="form-select"
                            required>

                            <option value="">Select days</option>

                            <option value="1">1 Day</option>
                            <option value="3">3 Days</option>
                            <option value="7">7 Days</option>
                            <option value="15">15 Days</option>

                        </select>

                    </div>

                    <div class="mb-3">
                        <label class="form-label">
                            Remarks (Optional)
                        </label>

                        <textarea 
                            name="remarks"
                            class="form-control"></textarea>
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
                        class="btn btn-primary">
                        Save Changes
                    </button>

                </div>

            </form>

        </div>
    </div>
</div>

<div class="modal fade" id="historyModal" tabindex="-1">

    <div class="modal-dialog modal-lg">

        <div class="modal-content">

            <div class="modal-header">

                <h5 class="modal-title">
                    Borrowing History
                </h5>

                <button 
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body">

                <div class="mb-3">

                    <strong>Borrower:</strong>
                    <span id="history_user"></span>

                    <br>

                    <strong>Book:</strong>
                    <span id="history_book"></span>

                </div>

                <div id="history_content">

                    <div class="text-center py-3">
                        Loading history...
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // RETURN MODAL
    const returnModal = document.getElementById('returnModal');

    returnModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const user = button.getAttribute('data-user');
        const book = button.getAttribute('data-book');
        const due = button.getAttribute('data-due');
        const daily_overdue_fine = button.getAttribute('data-daily_overdue_fine');

        document.getElementById('return_user').innerText = user;
        document.getElementById('return_book').innerText = book;
        document.getElementById('return_id').value = id;

        // OVERDUE CHECK
        const dueDate = new Date(due);
        const now = new Date();

        const fineNotice = document.getElementById('fine_notice');

        if (now > dueDate) {

            const diffMs = now - dueDate;

            const daysLate = Math.ceil(
                diffMs / (1000 * 60 * 60 * 24)
            );

            const finePerDay = daily_overdue_fine;

            const estimatedFine = daysLate * finePerDay;

            fineNotice.innerHTML = `
                <div class="alert alert-danger">

                    <strong>Overdue Detected</strong>
                    <br>

                    Late by: ${daysLate} day(s)
                    <br>

                    Fine Rate: ₱${finePerDay} per day
                    <br>

                    Estimated Fine:
                    ₱${finePerDay} × ${daysLate}
                    = <strong>₱${estimatedFine}</strong>

                    <br><br>

                    A fine record will automatically be created after return.

                </div>
            `;
        }
        else {

            fineNotice.innerHTML = '';
        }

    });




    // EXTEND MODAL
    const extendModal = document.getElementById('extendModal');

    extendModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const user = button.getAttribute('data-user');
        const book = button.getAttribute('data-book');
        const due = button.getAttribute('data-due');

        document.getElementById('extend_user').innerText = user;
        document.getElementById('extend_book').innerText = book;
        document.getElementById('extend_due').innerText = due;
        document.getElementById('extend_id').value = id;
    });

});

document.addEventListener('DOMContentLoaded', function () {

    const historyModal = document.getElementById('historyModal');

    historyModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const borrowingId = button.getAttribute('data-id');
        const user = button.getAttribute('data-user');
        const book = button.getAttribute('data-book');

        // set modal info
        document.getElementById('history_user').innerText = user;
        document.getElementById('history_book').innerText = book;

        // loading state
        document.getElementById('history_content').innerHTML = `
            <div class="text-center py-3">
                Loading history...
            </div>
        `;

        // fetch history
        fetch("<?= base_url('admin/borrowed_books/history/') ?>" + borrowingId)

            .then(response => response.text())

            .then(data => {
                document.getElementById('history_content').innerHTML = data;
            })

            .catch(error => {

                document.getElementById('history_content').innerHTML = `
                    <div class="alert alert-danger">
                        Failed to load borrowing history.
                    </div>
                `;
            });

    });

});
</script>

<?= $this->endSection() ?>