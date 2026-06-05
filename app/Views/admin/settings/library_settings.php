<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Settings
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Settings
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <!-- SETTINGS CARD -->
    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="fw-bold mb-1">
                    Library Settings
                </h5>

                <div class="text-muted small">
                    Configure borrowing, reservation, and fine policies
                </div>
            </div>
        </div>

        <!-- BODY -->
        <div class="card-body">

            <!-- SETTINGS NAV -->
            <?= view('partials/admin/settings_nav') ?>

            <!-- SUCCESS MESSAGE -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success mt-3">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <!-- SETTINGS FORM -->
            <form action="/admin/library_settings/update" method="POST">

                <div class="row mt-4">

                    <!-- LEFT SIDE -->
                    <div class="col-lg-6">

                        <!-- BORROWING RULES -->
                        <div class="card border h-100">
                            <div class="card-body">

                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-book me-2"></i>
                                    Borrowing Rules
                                </h5>

                                <!-- BORROW DAYS -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Borrow Duration
                                    </label>

                                    <div class="input-group">
                                        <input 
                                            type="number"
                                            name="borrow_days"
                                            class="form-control"
                                            value="<?= $settings['borrow_days'] ?>"
                                            min="1"
                                            required
                                        >

                                        <span class="input-group-text">
                                            Days
                                        </span>
                                    </div>

                                    <small class="text-muted">
                                        Number of days before a borrowed book becomes overdue.
                                    </small>
                                </div>

                                <!-- MAX BORROW -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Maximum Borrowed Books
                                    </label>

                                    <div class="input-group">
                                        <input 
                                            type="number"
                                            name="max_borrow_books"
                                            class="form-control"
                                            value="<?= $settings['max_borrow_books'] ?>"
                                            min="1"
                                            required
                                        >

                                        <span class="input-group-text">
                                            Books
                                        </span>
                                    </div>

                                    <small class="text-muted">
                                        Maximum books a user can borrow simultaneously.
                                    </small>
                                </div>

                            </div>
                        </div>

                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-lg-6">

                        <!-- RESERVATION RULES -->
                        <div class="card border h-100">
                            <div class="card-body">

                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-clock me-2"></i>
                                    Reservation Rules
                                </h5>

                                <!-- MAX RESERVATION -->
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Maximum Reserved Books
                                    </label>

                                    <div class="input-group">
                                        <input 
                                            type="number"
                                            name="max_reservation_books"
                                            class="form-control"
                                            value="<?= $settings['max_reservation_books'] ?>"
                                            min="1"
                                            required
                                        >

                                        <span class="input-group-text">
                                            Books
                                        </span>
                                    </div>

                                    <small class="text-muted">
                                        Maximum books a user can reserve simultaneously.
                                    </small>
                                </div>

                                <!-- RESERVATION EXPIRY -->
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Reservation Expiry
                                    </label>

                                    <div class="input-group">
                                        <input 
                                            type="number"
                                            name="reservation_expiry_days"
                                            class="form-control"
                                            value="<?= $settings['reservation_expiry_days'] ?>"
                                            min="1"
                                            required
                                        >

                                        <span class="input-group-text">
                                            Days
                                        </span>
                                    </div>

                                    <small class="text-muted">
                                        Days allowed for the next reserver to claim the book.
                                    </small>
                                </div>

                            </div>
                        </div>

                    </div>

                </div>

                <!-- FINES SECTION -->
                <div class="card border mt-4">
                    <div class="card-body">

                        <h5 class="fw-bold mb-4">
                            <i class="fas fa-money-bill-wave me-2"></i>
                            Fine Rules
                        </h5>

                        <div class="row">

                            <!-- DAILY FINE -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Daily Overdue Fine
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">
                                            ₱
                                        </span>

                                        <input 
                                            type="number"
                                            step="0.01"
                                            name="daily_overdue_fine"
                                            class="form-control"
                                            value="<?= $settings['daily_overdue_fine'] ?>"
                                            min="0"
                                            required
                                        >
                                    </div>

                                    <small class="text-muted">
                                        Fine charged per overdue day.
                                    </small>
                                </div>
                            </div>

                            <!-- MAX FINE -->
                            <div class="col-lg-6">
                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        Maximum Fine Amount
                                    </label>

                                    <div class="input-group">
                                        <span class="input-group-text">
                                            ₱
                                        </span>

                                        <input 
                                            type="number"
                                            step="0.01"
                                            name="max_fine_amount"
                                            class="form-control"
                                            value="<?= $settings['max_fine_amount'] ?>"
                                            min="0"
                                            required
                                        >
                                    </div>

                                    <small class="text-muted">
                                        Maximum fine limit per borrowing transaction.
                                    </small>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <!-- SAVE BUTTON -->
                <div class="border-top pt-3 mt-4 text-end">

                    <button type="submit" class="btn btn-dark px-4">
                        <i class="fas fa-save me-1"></i>
                        Save Settings
                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

<?= $this->endSection() ?>