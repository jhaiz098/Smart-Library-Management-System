<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('header') ?>
    Borrowed Books Management
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <!-- PAGE HEADER CARD -->
    <div class="card border-0 shadow-sm mb-3">
        <div class="card-body d-flex justify-content-between align-items-center flex-wrap gap-2">

            <div>
                <div class="fw-bold fs-5">Borrowed Books</div>
                <div class="text-muted small">
                    Manage borrowed and returned book records
                </div>
            </div>

        </div>
    </div>

    <!-- MAIN CARD -->
    <div class="card border-0 shadow-sm">

        <!-- ALERTS -->
        <div class="card-body pb-0">

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

        </div>

        <!-- TABS + CONTENT -->
        <div class="card-body pt-0">

            <ul class="nav nav-pills mb-3 border-bottom pb-2">

                <li class="nav-item">
                    <a href="borrowed"
                    class="nav-link d-flex align-items-center gap-2 <?= ($borrow_status ?? '') == 'borrowed' ? 'active' : '' ?>">

                        <i class="bi bi-journal-arrow-down"></i>
                        <span>Borrowed</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="returned"
                    class="nav-link d-flex align-items-center gap-2 <?= ($borrow_status ?? '') == 'returned' ? 'active' : '' ?>">

                        <i class="bi bi-journal-check"></i>
                        <span>Returned</span>
                    </a>
                </li>

            </ul>

            <form method="get" action="<?= current_url() ?>" class="row g-2">

                <div class="col-md-6">
                    <input
                        type="search"
                        name="search"
                        placeholder="Search title..."
                        class="form-control"
                        value=""
                    >
                </div>
                
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary w-100">
                        Search
                    </button>
                </div>

                <div class="col-md-2">
                    <!-- SORT -->
                    <select name="sort" class="form-select" onchange="this.form.submit()">
                        <option value="">Sort By</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <!-- FILTER -->
                    <select name="category" class="form-select" onchange="this.form.submit()">
                        <option value="">All Categories</option>
                    </select>
                </div>
            </form>
            
            <hr>
            
            <?= $this->include('partials/admin/borrowed_books_filters') ?>

            <!-- RENDER TABLE -->
            <?= $this->renderSection('render_borrowed') ?>

        </div>

    </div>

</div>

<style>
.nav-pills .nav-link {
    border-radius: 8px;
    font-weight: 500;
}

.card {
    border-radius: 12px;
}

.alert {
    border-radius: 10px;
}
</style>

<?= $this->endSection() ?>