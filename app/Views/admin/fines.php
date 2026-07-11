<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Paid Fines
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Fines
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="p-3">
    <div class="card">
        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        Fine Management
                    </h5>

                    <div class="text-muted small">
                        Manage unpaid and paid fines
                    </div>

                </div>

            </div>

        </div>

        <div class="card-body">

            <ul class="nav nav-pills mb-3 border-bottom pb-2">

                <li class="nav-item">
                    <a href="?type=all"
                    class="nav-link d-flex align-items-center gap-2 <?= ($fine_status ?? '') == 'all' ? 'active' : '' ?>">

                        <i class="bi bi-collection"></i>
                        <span>All</span>

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=unpaid"
                    class="nav-link d-flex align-items-center gap-2 <?= ($fine_status ?? '') == 'unpaid' ? 'active' : '' ?>">

                        <i class="bi bi-exclamation-circle"></i>
                        <span>Unpaid</span>

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=paid"
                    class="nav-link d-flex align-items-center gap-2 <?= ($fine_status ?? '') == 'paid' ? 'active' : '' ?>">

                        <i class="bi bi-check-circle"></i>
                        <span>Paid</span>

                    </a>
                </li>

            </ul>
            
            
            <div>
                <!-- SEARCH -->
                <form
                    method="get"
                    action="<?= current_url() ?>"
                    class="row g-2"
                >

                    <!-- KEEP CURRENT TAB -->
                    <input
                        type="hidden"
                        name="type"
                        value="<?= $request_status ?? 'all' ?>"
                    >

                    <div class="col-md-6">

                        <input
                            type="search"
                            name="search"
                            class="form-control"
                            placeholder="Search request code, borrower, or book title..."
                            value="<?= $_GET['search'] ?? '' ?>"
                        >

                    </div>

                    <div class="col-md-2">

                        <button
                            type="submit"
                            class="btn btn-primary w-100"
                        >
                            Search
                        </button>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="sort"
                            class="form-select"
                            onchange="this.form.submit()"
                        >

                            <option value="">Sort By</option>

                            <option value="newest"
                                <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>
                                Recently Requested
                            </option>

                            <option value="oldest"
                                <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>
                                Earliest Requested
                            </option>

                            <option value="title_asc"
                                <?= ($sort ?? '') == 'title_asc' ? 'selected' : '' ?>>
                                Book Title Ascending
                            </option>

                            <option value="title_desc"
                                <?= ($sort ?? '') == 'title_desc' ? 'selected' : '' ?>>
                                Book Title Descending
                            </option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="filter"
                            class="form-select"
                            onchange="this.form.submit()"
                        >

                            <option value="">All Requests</option>

                            <option value="today"
                                <?= ($filter ?? '') == 'today' ? 'selected' : '' ?>>
                                Today
                            </option>

                            <option value="this_week"
                                <?= ($filter ?? '') == 'this_week' ? 'selected' : '' ?>>
                                This Week
                            </option>

                            <option value="this_month"
                                <?= ($filter ?? '') == 'this_month' ? 'selected' : '' ?>>
                                This Month
                            </option>

                        </select>

                    </div>

                </form>
            </div>

            <hr>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-body">

                    <div class="table-responsive rounded-3 border bg-white shadow-sm">

                        <table class="table table-hover align-middle mb-0">

                            <thead class="text-center">

                                <tr>
                                    <th>#</th>
                                    <th>Fine Code</th>
                                    <th>Borrowing Code</th>
                                    <th>Borrower</th>
                                    <th>Book</th>
                                    <th>Amount</th>
                                    <th>Status</th>
                                    <?php if($fine_status == 'all' || $fine_status == 'paid'): ?>
                                    <th>Paid By</th>
                                    <th>Paid At</th>
                                    <?php endif; ?>
                                    <th>Issued At</th>
                                    <?php if($fine_status == 'unpaid'): ?>
                                    <th>Actions</th>
                                    <?php endif; ?>
                                </tr>

                            </thead>

                            <tbody>

                                <?php if(empty($records)): ?>

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No fines found.
                                        </td>
                                    </tr>

                                <?php else: ?>

                                    <?php $i = 1; foreach($records as $fine): ?>

                                        <tr>

                                            <!-- # -->
                                            <td class="text-center">
                                                <?= $i++ ?>
                                            </td>

                                            <!-- FINE CODE -->
                                            <td class="text-center">

                                                <span class="badge bg-dark rounded-pill px-3 py-2">
                                                    <?= esc($fine['fine_ref']) ?>
                                                </span>

                                            </td>

                                            <!-- BORROWING CODE -->
                                            <td class="text-center">

                                                <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                    <?= esc($fine['borrowing_code']) ?>
                                                </span>

                                            </td>

                                            <!-- BORROWER -->
                                            <td>

                                                <?= esc($fine['borrower_library_id']) ?>

                                                <br>

                                                <?= esc($fine['borrower_full_name']) ?>

                                            </td>

                                            <!-- BOOK -->
                                            <td>

                                                <?= esc($fine['book_title']) ?>

                                            </td>

                                            <!-- AMOUNT -->
                                            <td class="text-center">
                                                
                                                <?php if($fine['status'] === 'paid'): ?>

                                                    <span class="fw-bold text-success">

                                                <?php else: ?>

                                                    <span class="fw-bold text-danger">

                                                <?php endif; ?>
                                                    ₱<?= number_format($fine['amount'], 2) ?>
                                                </span>

                                            </td>

                                            <!-- STATUS -->
                                            <td class="text-center">

                                                <?php if($fine['status'] === 'paid'): ?>

                                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                                        Paid
                                                    </span>

                                                <?php else: ?>

                                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                                        Unpaid
                                                    </span>

                                                <?php endif; ?>

                                            </td>
                                            
                                            <?php if($fine_status == 'all' || $fine_status == 'paid'): ?>
                                            <!-- PAID BY -->
                                            <td>

                                                <?php if(!empty($fine['payer_full_name'])): ?>

                                                    <?= esc($fine['payer_library_id']) ?>

                                                    <br>

                                                    <?= esc($fine['payer_full_name']) ?>

                                                <?php else: ?>

                                                    <span class="text-muted">—</span>

                                                <?php endif; ?>

                                            </td>

                                            <!-- PAID AT -->
                                            <td class="text-center">

                                                <?php if(!empty($fine['paid_at'])): ?>

                                                    <?= date(
                                                        'M d, Y',
                                                        strtotime($fine['paid_at'])
                                                    ) ?>

                                                <?php else: ?>

                                                    <span class="text-muted">—</span>

                                                <?php endif; ?>

                                            </td>
                                            <?php endif; ?>

                                            <!-- ISSUED AT -->
                                            <td class="text-center">

                                                <?= date(
                                                    'M d, Y',
                                                    strtotime($fine['created_at'])
                                                ) ?>

                                            </td>
                                            
                                            <?php if($fine_status == 'unpaid'): ?>
                                            <!-- ACTIONS -->
                                            <td class="text-center">

                                                <button type="button" 
                                                    class="btn btn-sm btn-success"

                                                    data-bs-toggle="modal"
                                                    data-bs-target="#paymentModal"

                                                    data-id="<?= $fine['id'] ?>"
                                                    data-user="<?= $fine['borrower_full_name'] ?>"
                                                    data-book="<?= $fine['book_title'] ?>"

                                                    data-daily-fine="<?= $fine['daily_overdue_fine'] ?>"
                                                    data-days-late="<?= $fine['days_late'] ?>"
                                                    data-total="<?= $fine['amount'] ?>"
                                                    data-max-fine="<?= $fine['max_fine_amount'] ?>">

                                                    Record Payment
                                                </button>
                                            </td>
                                            <?php endif; ?>

                                        </tr>

                                    <?php endforeach; ?>

                                <?php endif; ?>

                            </tbody>

                        </table>

                        <div class="mt-3 d-flex justify-content-center">
                            <?= $pager->links('default', 'bootstrap_full') ?>
                        </div>

                    </div>
                </div>
            </div>
        </div>
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