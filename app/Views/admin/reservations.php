<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Reservations
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Reservations
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="p-3">
    <div class="card border-0 shadow-sm">
        <!-- HEADER -->
        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        Book Reservations
                    </h5>

                    <div class="text-muted small">
                        Track reservation queues, claims, and reservation status
                    </div>

                </div>

            </div>

        </div>

        <!-- BODY -->
        <div class="card-body">
            <ul class="nav nav-pills gap-2 mb-3">

                <li class="nav-item">
                    <a href="?type=all"
                    class="nav-link <?= ($reservation_status ?? 'all') == 'all' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-bookmark-check-fill me-1"></i>
                        All

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=pending"
                    class="nav-link <?= ($reservation_status ?? '') == 'pending' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-hourglass-split me-1"></i>
                        Pending

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=fulfilled"
                    class="nav-link <?= ($reservation_status ?? '') == 'fulfilled' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-check-circle-fill me-1"></i>
                        Fulfilled

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=expired"
                    class="nav-link <?= ($reservation_status ?? '') == 'expired' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-clock-history me-1"></i>
                        Expired

                    </a>
                </li>

                <li class="nav-item">
                    <a href="?type=cancelled"
                    class="nav-link <?= ($reservation_status ?? '') == 'cancelled' ? 'active' : 'text-dark' ?>">

                        <i class="bi bi-x-circle-fill me-1"></i>
                        Cancelled

                    </a>
                </li>

            </ul>

            <div class="filter-toolbar">

                <form method="get" action="<?= current_url() ?>" class="row g-2 align-items-center">

                    <input
                        type="hidden"
                        name="type"
                        value="<?= esc($reservation_status ?? 'all') ?>"
                    >

                    <!-- SEARCH -->
                    <div class="col-md-6">

                        <div class="search-box">

                            <i class="bi bi-search"></i>

                            <input
                                type="search"
                                name="search"
                                placeholder="Search reservation code, user, or book..."
                                class="form-control"
                                value="<?= $_GET['search'] ?? '' ?>"
                            >

                        </div>

                    </div>

                    <!-- SEARCH BUTTON -->
                    <div class="col-md-2">

                        <button class="btn btn-primary w-100">
                            Search
                        </button>

                    </div>

                    <!-- SORT -->
                    <div class="col-md-2">

                        <select
                            name="sort"
                            class="form-select filter-select"
                            onchange="this.form.submit()"
                        >

                            <option value="">Sort By</option>

                            <option value="newest"
                                <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>
                                Recently Reserved
                            </option>

                            <option value="oldest"
                                <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>
                                Earliest Reserved
                            </option>

                            <option value="expiration_asc"
                                <?= ($sort ?? '') == 'expiration_asc' ? 'selected' : '' ?>>
                                Expiring Soon
                            </option>

                            <option value="expiration_desc"
                                <?= ($sort ?? '') == 'expiration_desc' ? 'selected' : '' ?>>
                                Expiring Last
                            </option>

                        </select>

                    </div>

                    <!-- STATUS FILTER -->
                    <div class="col-md-2">

                        <select
                            name="status"
                            class="form-select filter-select"
                            onchange="this.form.submit()"
                        >

                            <option value="">All Statuses</option>

                            <option value="pending"
                                <?= ($status ?? '') == 'pending' ? 'selected' : '' ?>>
                                Pending
                            </option>

                            <option value="fulfilled"
                                <?= ($status ?? '') == 'fulfilled' ? 'selected' : '' ?>>
                                Fulfilled
                            </option>

                            <option value="expired"
                                <?= ($status ?? '') == 'expired' ? 'selected' : '' ?>>
                                Expired
                            </option>

                            <option value="cancelled"
                                <?= ($status ?? '') == 'cancelled' ? 'selected' : '' ?>>
                                Cancelled
                            </option>

                        </select>

                    </div>

                </form>

            </div>

            <hr>

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

            <div class="table-responsive rounded-3 border bg-white shadow-sm">

                <table class="table table-hover align-middle mb-0">

                    <thead class="bg-light border-bottom">

                        <tr>

                            <th class="text-center">#</th>

                            <th>Reserver</th>

                            <th>Book</th>

                            <th class="text-center">Reserved At</th>

                            <?php if($reservation_status == 'pending'): ?>
                            <th class="text-center">Expires At</th>
                            <?php endif; ?>
                            
                            <?php if($reservation_status == 'expired'): ?>
                            <th class="text-center">Expired At</th>
                            <?php endif; ?>

                            <?php if($reservation_status == 'all'): ?>
                            <th class="text-center">Status</th>
                            <?php endif; ?>

                        </tr>

                    </thead>

                    <tbody>

                        <?php if(empty($records)): ?>

                            <tr>

                                <td colspan="8" class="text-center py-4 text-muted">
                                    No reservations found.
                                </td>

                            </tr>

                        <?php else: ?>

                            <?php $i = 1; foreach($records as $reservation): ?>

                                <tr>

                                    <!-- # -->
                                    <td class="text-center">
                                        <?= $i++ ?>
                                    </td>

                                    <!-- BORROWER -->
                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($reservation['full_name']) ?>
                                        </div>
                                        <div class="text-muted small">
                                            <?= esc($reservation['library_id']) ?>
                                        </div>

                                    </td>

                                    <!-- BOOK -->
                                    <td>

                                        <div class="fw-semibold">
                                            <?= esc($reservation['book_title']) ?>
                                        </div>

                                    </td>

                                    <!-- RESERVED DATE -->
                                    <td class="text-center">

                                        <div>
                                            <?= date('M d, Y', strtotime($reservation['reservation_date'])) ?>
                                        </div>

                                        <small class="text-muted">
                                            <?= date('h:i A', strtotime($reservation['reservation_date'])) ?>
                                        </small>

                                    </td>

                                    <?php if($reservation_status == 'pending' || $reservation_status == 'expired'): ?>
                                    <!-- EXPIRATION -->
                                    <td class="text-center">

                                        <?php if(!empty($reservation['expiration_date'])): ?>

                                            <div>
                                                <?= date('M d, Y', strtotime($reservation['expiration_date'])) ?>
                                            </div>

                                            <small class="text-muted">
                                                <?= date('h:i A', strtotime($reservation['expiration_date'])) ?>
                                            </small>

                                        <?php else: ?>

                                            <span class="text-muted">—</span>

                                        <?php endif; ?>

                                    </td>
                                    <?php endif; ?>

                                    <?php if($reservation_status == 'all'): ?>
                                    <!-- STATUS -->
                                    <td class="text-center">

                                        <?php if($reservation['status'] == 'pending'): ?>

                                            <span class="badge bg-warning text-dark rounded-pill px-3 py-2">
                                                Pending
                                            </span>

                                        <?php elseif($reservation['status'] == 'fulfilled'): ?>

                                            <span class="badge bg-success rounded-pill px-3 py-2">
                                                Fulfilled
                                            </span>

                                        <?php elseif($reservation['status'] == 'expired'): ?>

                                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                                Expired
                                            </span>

                                        <?php elseif($reservation['status'] == 'cancelled'): ?>

                                            <span class="badge bg-secondary rounded-pill px-3 py-2">
                                                Cancelled
                                            </span>

                                        <?php endif; ?>

                                    </td>
                                    <?php endif; ?>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

            </div>

        </div>
    </div>
</div>

<style>
    .table tbody tr:hover {
        background: #f8f9fa;
    }
    .filter-toolbar{
        background: #fff;
        padding: 14px;
        border: 1px solid #e9ecef;
        border-radius: 14px;
    }

    .search-box{
        position: relative;
    }

    .search-box i{
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 2;
    }

    .search-box .form-control{
        padding-left: 40px;
        border-radius: 10px;
        border: 1px solid #dee2e6;
        height: 42px;
    }

    .filter-select{
        border-radius: 10px;
        height: 42px;
    }

    .filter-select:focus,
    .search-box .form-control:focus{
        border-color: #86b7fe;
        box-shadow: 0 0 0 .15rem rgba(13,110,253,.15);
    }

    .filter-toolbar .btn-primary{
        height: 42px;
        border-radius: 10px;
        font-weight: 600;
    }
</style>
<?= $this->endSection() ?>