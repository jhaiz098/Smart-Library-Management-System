<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('header') ?>
Book Management
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <div class="card border-0 shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white">

            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

                <div>

                    <h5 class="fw-bold mb-1">
                        Book Management
                    </h5>

                    <div class="text-muted small">
                        Manage active and draft books
                    </div>

                </div>

            </div>

        </div>

        <div class="card-body">

            <!-- ALERTS -->

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

            <!-- SEARCH + FILTER -->
            
            <!-- BOOK STATUS NAV -->

            <ul class="nav nav-pills gap-2 mb-3">

                <li class="nav-item">

                    <a
                        href="book_management_active"
                        class="nav-link <?= ($book_status == 'active') ? 'active' : 'text-dark' ?>"
                    >

                        <i class="bi bi-book-fill me-1"></i>
                        Active

                    </a>

                </li>

                <li class="nav-item">

                    <a
                        href="book_management_draft"
                        class="nav-link <?= ($book_status == 'draft') ? 'active' : 'text-dark' ?>"
                    >

                        <i class="bi bi-file-earmark-text-fill me-1"></i>
                        Draft

                    </a>

                </li>

            </ul>

            <form
                method="get"
                action="<?= current_url() ?>"
                class="row g-2"
            >

                <div class="col-md-6">

                    <input
                        type="search"
                        name="search"
                        class="form-control"
                        placeholder="Search book title..."
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

                        <option value="title_asc"
                            <?= ($sort ?? '') == 'title_asc' ? 'selected' : '' ?>>
                            Title Ascending
                        </option>

                        <option value="title_desc"
                            <?= ($sort ?? '') == 'title_desc' ? 'selected' : '' ?>>
                            Title Descending
                        </option>

                        <option value="newest"
                            <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>
                            Recently Created
                        </option>

                        <option value="oldest"
                            <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>
                            Earliest Created
                        </option>

                    </select>

                </div>

                <div class="col-md-2">

                    <select
                        name="category"
                        class="form-select"
                        onchange="this.form.submit()"
                    >

                        <option value="">All Categories</option>

                        <?php foreach($categories as $cat): ?>

                            <option
                                value="<?= $cat['id'] ?>"
                                <?= ($category ?? '') == $cat['id'] ? 'selected' : '' ?>
                            >

                                <?= esc($cat['name']) ?>

                            </option>

                        <?php endforeach; ?>

                    </select>

                </div>

            </form>

            <hr>

            <a
                href="/admin/book_management/add_book"
                class="btn btn-primary btn-sm px-3 py-2 my-2"
            >
                + Add Book
            </a>

            <!-- BOOK CONTENT -->

            <?= $this->renderSection('render_books') ?>

        </div>

    </div>

</div>

<?= $this->endSection() ?>