<?= $this->extend('layouts/borrowed_books_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Borrowed Books
<?= $this->endSection() ?>

<?= $this->section('render_borrowed') ?>

<div class="border-0 shadow-sm">

        <!-- FLASH -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success border-0 shadow-sm">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger border-0 shadow-sm">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

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
                        <th>Status</th>
                        <th>Issued By</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    <?php if(empty($borrowed_books)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                No borrowed books found
                            </td>
                        </tr>
                    <?php else: ?>

                        <?php $i = 1; foreach($borrowed_books as $bb): ?>

                            <tr>

                                <!-- ROW NUMBER -->
                                <td class="text-muted fw-semibold text-center">
                                    <?= $i++ ?>
                                </td>

                                <!-- BORROWER -->
                                <td>
                                    <div class="fw-semibold">
                                        <?= esc($bb['borrower_name']) ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= esc($bb['borrower_library_id']) ?>
                                    </div>
                                </td>

                                <!-- BOOK -->
                                <td class="fw-semibold">
                                    <?= esc($bb['book_title']) ?>
                                </td>

                                <!-- BORROW DATE -->
                                <td class="text-muted">
                                    <?= date('F d, Y', strtotime($bb['borrow_date'])) ?>
                                </td>

                                <!-- DUE DATE -->
                                <td class="text-muted">
                                    <?= date('F d, Y', strtotime($bb['due_date'])) ?>
                                </td>

                                <!-- STATUS -->
                                <td>
                                    <?php if($bb['status_label'] === 'Overdue'): ?>
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
                                    <div class="small">
                                        <?= esc($bb['issued_by_name']) ?>
                                    </div>
                                    <div class="text-muted small">
                                        <?= esc($bb['issued_by_library_id']) ?>
                                    </div>
                                </td>

                                <!-- ACTIONS -->
                                <td class="text-center">

                                    <div class="dropdown">

                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                data-bs-toggle="dropdown">
                                            Actions
                                        </button>

                                        <ul class="dropdown-menu">

                                            <li>
                                                <button class="dropdown-item text-success"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#returnModal"
                                                    data-id="<?= $bb['id'] ?>"
                                                    data-user="<?= $bb['borrower_name'] ?>"
                                                    data-book="<?= $bb['book_title'] ?>"
                                                    data-due="<?= $bb['due_date'] ?>"
                                                    data-daily_overdue_fine="<?= $daily_overdue_fine ?>"
                                                    data-max_fine_amount="<?= $max_fine_amount ?>">
                                                    Return Book
                                                </button>
                                            </li>

                                            <li>
                                                <button class="dropdown-item text-primary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#extendModal"
                                                    data-id="<?= $bb['id'] ?>"
                                                    data-user="<?= $bb['borrower_name'] ?>"
                                                    data-book="<?= $bb['book_title'] ?>"
                                                    data-due="<?= $bb['due_date'] ?>">
                                                    Extend Due Date
                                                </button>
                                            </li>

                                            <li><hr class="dropdown-divider"></li>

                                            <li>
                                                <button class="dropdown-item text-dark"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#historyModal"
                                                    data-id="<?= $bb['id'] ?>"
                                                    data-user="<?= $bb['borrower_name'] ?>"
                                                    data-book="<?= $bb['book_title'] ?>">
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

    // RESET WHEN CLOSED
    returnModal.addEventListener('hidden.bs.modal', function () {

        document.getElementById('fine_notice').innerHTML = '';

    });

    // SHOW MODAL
    returnModal.addEventListener('show.bs.modal', async function (event) {

        const button = event.relatedTarget;

        const id = button.getAttribute('data-id');
        const user = button.getAttribute('data-user');
        const book = button.getAttribute('data-book');
        const due = button.getAttribute('data-due');
        const fineRate = parseFloat(button.getAttribute('data-daily_overdue_fine') || 0);
        const maxFineAmount = parseFloat(button.getAttribute('data-max_fine_amount') || 0);

        const fineNotice = document.getElementById('fine_notice');

        document.getElementById('return_user').innerText = user;
        document.getElementById('return_book').innerText = book;
        document.getElementById('return_id').value = id;

        fineNotice.innerHTML = '';

        // 🔥 SERVER TIME (source of truth)
        const res = await fetch("<?= base_url('server_time') ?>");
        const data = await res.json();

        const now = new Date(data.now);
        const dueDate = new Date(due.replace(' ', 'T'));

        console.log('SERVER NOW:', now);
        console.log('DUE:', dueDate);

        if (now > dueDate) {

            const diffMs = now - dueDate;

            const daysLate = Math.ceil(diffMs / (1000 * 60 * 60 * 24));

            // 💰 calculations
            const uncappedTotal = daysLate * fineRate;

            const cappedTotal = maxFineAmount > 0
                ? Math.min(uncappedTotal, maxFineAmount)
                : uncappedTotal;

            fineNotice.innerHTML = `
                <div class="alert alert-danger">

                    <strong>Overdue Detected</strong><br>
                    Late by: ${daysLate} day(s)<br>
                    Fine Rate: ₱${fineRate} per day<br>

                    <hr>

                    <div>
                        Uncapped Total: ₱${uncappedTotal}
                    </div>

                    <div>
                        Max Fine Allowed: ₱${maxFineAmount}
                    </div>

                    <div>
                        Final Fine:
                        <strong class="${uncappedTotal > maxFineAmount ? 'text-warning' : ''}">
                            ₱${cappedTotal}
                        </strong>
                    </div>

                    ${uncappedTotal > maxFineAmount ? `
                        <div class="text-danger mt-2 small">
                            ⚠ Fine exceeds max limit. Cap will be applied.
                        </div>
                    ` : ''}

                </div>
            `;
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





    historyModal.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        const borrowingId = button.getAttribute('data-id');
        const user = button.getAttribute('data-user');
        const book = button.getAttribute('data-book');

        // 🔥 THIS WAS MISSING
        document.getElementById('history_user').innerText = user;
        document.getElementById('history_book').innerText = book;

        document.getElementById('history_content').innerHTML =
            `<div class="text-center py-3">Loading history...</div>`;

        fetch("<?= base_url('admin/borrowed_books/history/') ?>" + borrowingId)
            .then(res => res.text())
            .then(data => {
                document.getElementById('history_content').innerHTML = data;
            })
            .catch(() => {
                document.getElementById('history_content').innerHTML =
                    `<div class="alert alert-danger">Failed to load history</div>`;
            });
    });

});
</script>

<?= $this->endSection() ?>