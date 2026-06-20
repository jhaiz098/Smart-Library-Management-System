<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('header') ?>
    Book Management
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
                            value="<?= $_GET['search'] ?? '' ?>"
                        >

                        <button type="submit" class="btn btn-secondary">
                            Search
                        </button>

                        <!-- SORT -->
                        <select name="sort" class="form-select" onchange="this.form.submit()">
                            <option value="">Sort By</option>
                            <option value="title_asc" <?= ($sort ?? '') == 'title_asc' ? 'selected' : '' ?>>A-Z</option>
                            <option value="title_desc" <?= ($sort ?? '') == 'title_desc' ? 'selected' : '' ?>>Z-A</option>
                            <option value="newest" <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>Newest</option>
                            <option value="oldest" <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>Oldest</option>
                        </select>

                        <!-- FILTER -->
                        <select name="category" class="form-select" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            <?php foreach($categories as $cat): ?>
                                <option 
                                    value="<?= $cat['id'] ?>"
                                    <?= ($category ?? '') == $cat['id'] ? 'selected' : '' ?>
                                >
                                    <?= $cat['name'] ?>
                                </option>
                            <?php endforeach; ?>
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
                        <li class="nav-item"><a href="book_management_active" class="nav-link <?= ($book_status) == 'active' ? 'active' : '' ?>">Active</a></li>
                        <li class="nav-item"><a href="book_management_draft" class="nav-link <?= ($book_status) == 'draft' ? 'active' : '' ?>">Draft</a></li>
                    </ul>
                    <?= $this->renderSection('render_books') ?>
                </div>
            </div>
        </div>
    </div>

</div>
<?= $this->endSection() ?>