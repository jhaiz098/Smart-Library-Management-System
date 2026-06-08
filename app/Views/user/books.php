<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
User | Books
<?= $this->endSection() ?>

<?= $this->section('header') ?>
Books
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php
    // pagination offset (IMPORTANT)
    $page = $_GET['page'] ?? 1;
    $perPage = 10;
    $i = ($page - 1) * $perPage + 1;
?>

<div class="py-0 px-3">

    <!-- FLASH MESSAGE -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm d-flex align-items-center gap-2">
            <i class="bi bi-check-circle-fill"></i>
            <div><?= session()->getFlashdata('success') ?></div>
        </div>
    <?php endif; ?>

    <!-- MAIN CARD -->
    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white fw-semibold d-flex justify-content-between align-items-center">
            <span class="d-flex align-items-center gap-2">
                <i class="bi bi-journal-bookmark text-primary"></i>
                Books Catalog
            </span>

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0 fs-7">

                    <thead class="table-light text-uppercase">

                        <tr>
                            <th>#</th>
                            <th>Category</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Availability</th>
                            <th>Year</th>
                            <th>Publisher</th>
                            <th>Action</th>
                        </tr>

                    </thead>

                    <tbody>

                        <?php if(empty($books)): ?>

                            <tr>
                                <td colspan="9" class="text-center p-5 text-muted">

                                    <i class="bi bi-journal-x fs-1 d-block mb-2 opacity-50"></i>

                                    <div class="fw-semibold">No books available</div>
                                    <small>Check back later for new additions</small>

                                </td>
                            </tr>

                        <?php else: ?>

                            <?php foreach($books as $book): ?>

                                <tr>

                                    <!-- ROW NUMBER -->
                                    <td>
                                        <?= $i++ ?>
                                    </td>

                                    <td>
                                        <span class="badge rounded-pill bg-light border text-black px-3 py-2">
                                        <?= $book['category_name'] ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div>
                                            <?= esc($book['title']) ?>
                                        </div>

                                        <div class="small text-muted">

                                            <?php
                                                $description = strip_tags($book['description']);
                                                echo strlen($description) > 60
                                                    ? substr($description, 0, 60) . '...'
                                                    : $description;
                                            ?>

                                        </div>
                                    </td>

                                    <td>
                                        <?= $book['author'] ?>
                                    </td>

                                    <td>

                                        <?php if($book['availability'] === 'available'): ?>

                                            <span class="badge rounded-pill bg-success px-3 py-2">
                                                Available
                                            </span>

                                        <?php else: ?>

                                            <span class="badge rounded-pill bg-secondary px-3 py-2">
                                                Borrowed
                                            </span>

                                        <?php endif; ?>

                                    </td>

                                    <td>
                                        <?= $book['published_year'] ?>
                                    </td>

                                    <td>
                                        <?= $book['publisher'] ?>
                                    </td>

                                    <td>

                                        <a href="books/view/<?= $book['id'] ?>"
                                           class="btn btn-sm btn-outline-primary px-3">

                                            <i class="bi bi-eye me-1"></i> View

                                        </a>

                                    </td>

                                </tr>

                            <?php endforeach; ?>

                        <?php endif; ?>

                    </tbody>

                </table>

                <!-- PAGINATION -->
                <div class="mt-3 d-flex justify-content-center pb-3">
                    <?= $pager->links('default', 'bootstrap_full') ?>
                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>