<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('header') ?>
    Fines
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">
                
    <div class="card">
        <div class="card-header fw-bold">
            Manage books
        </div>
        
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                <!-- LEFT SIDE -->
                <div>
                    <a class="btn btn-primary fs-7" href="/admin/book_management/add_book">
                        + Add Book
                    </a>
                </div>

                <!-- RIGHT SIDE -->
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <!-- SEARCH -->
                    <form method="get" action="<?= current_url() ?>" class="d-flex gap-2">

                        <input
                            type="search"
                            name="search"
                            placeholder="Search title..."
                            class="form-control"
                            value=""
                        >

                        <button type="submit" class="btn btn-secondary">
                            Search
                        </button>

                        <!-- SORT -->
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Sort By</option>
                        </select>

                        <!-- FILTER -->
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                        </select>
                    </form>
                </div>
            </div>

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
                    <ul class="nav nav-tabs mb-3">
                        <li class="nav-item"><a href="unpaid_fines_list" class="nav-link <?= ($fine_status) == 'unpaid' ? 'active' : '' ?>">Unpaid</a></li>
                        <li class="nav-item"><a href="paid_fines_list" class="nav-link <?= ($fine_status) == 'paid' ? 'active' : '' ?>">Paid</a></li>
                    </ul>
                    <?= $this->renderSection('render_fines') ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>