<?= $this->extend('layouts/book_management_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Book Management
<?= $this->endSection() ?>

<?= $this->section('render_books') ?>

<div class="card">
    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-light">

                <tr class="text-muted small">

                    <th style="width:60px;">#</th>
                    <th>Category</th>
                    <th>Book</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>Availability</th>
                    <th>Created</th>
                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                <?php if(empty($active_books)): ?>

                    <tr>

                        <td colspan="9" class="text-center text-muted py-4">
                            No books available
                        </td>

                    </tr>

                <?php else: ?>

                    <?php $i = 1; ?>

                    <?php foreach($active_books as $book): ?>

                        <tr>

                            <!-- NUMBER -->

                            <td class="text-muted fw-semibold">
                                <?= $i++ ?>
                            </td>

                            <!-- CATEGORY -->

                            <td>

                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                                    <?= esc($book['category_name']) ?>
                                </span>

                            </td>

                            <!-- TITLE -->

                            <td>

                                <div class="fw-semibold">
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

                            <!-- AUTHOR -->

                            <td class="text-muted">
                                <?= esc($book['author']) ?>
                            </td>

                            <!-- PUBLISHER -->

                            <td class="text-muted">
                                <?= esc($book['publisher']) ?>
                            </td>

                            <!-- YEAR -->

                            <td>
                                <?= esc($book['published_year']) ?>
                            </td>

                            <!-- AVAILABILITY -->

                            <td>

                                <?php if($book['availability'] == 'available'): ?>

                                    <span class="badge bg-success rounded-pill px-3 py-2">
                                        <?= ucfirst($book['availability']) ?>
                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger rounded-pill px-3 py-2">
                                        <?= ucfirst($book['availability']) ?>
                                    </span>

                                <?php endif; ?>

                            </td>

                            <!-- CREATED -->

                            <td class="small text-muted">

                                <?= date('M d, Y', strtotime($book['created_at'])) ?>

                            </td>

                            <!-- ACTIONS -->

                            <td>

                                <div class="dropdown">

                                    <button
                                        class="btn btn-sm btn-light border dropdown-toggle"
                                        data-bs-toggle="dropdown"
                                    >
                                        Actions
                                    </button>

                                    <ul class="dropdown-menu">

                                        <li>

                                            <a
                                                class="dropdown-item"
                                                href="/admin/book_management/edit_book/<?= $book['id'] ?>"
                                            >
                                                Edit
                                            </a>

                                        </li>

                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>

                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item text-dark"
                                                data-bs-toggle="modal"
                                                data-bs-target="#unPublishModal"
                                                data-id="<?= $book['id'] ?>"
                                            >
                                                Unpublish
                                            </button>

                                        </li>

                                        <li>

                                            <button
                                                type="button"
                                                class="dropdown-item text-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                data-id="<?= $book['id'] ?>"
                                            >
                                                Delete
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

    <div class="mt-4 d-flex justify-content-center">

        <?= $active_pager
            ->only(['search', 'sort', 'category'])
            ->links('active', 'bootstrap_full') ?>

    </div>
</div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">

                    <h5 class="modal-title text-danger">
                        Delete Book
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <p>
                        Are you sure you want to delete this book?
                    </p>

                    <div class="alert alert-danger mb-0">
                        This action cannot be undone.
                    </div>

                </div>
                <div class="modal-footer">

                    <form id="deleteForm" method="post">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-danger">
                            Yes, Delete
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="unPublishModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">

                    <h5 class="modal-title text-warning">
                        Unpublish Book
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <p>
                        Are you sure you want to unpublish this book?
                    </p>

                    <div class="alert alert-warning mb-0">
                        The book will no longer appear in active listings.
                    </div>

                </div>
                <div class="modal-footer">

                    <form id="unPublishForm" method="post">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-dark">
                            Yes, Unpublish
                        </button>
                    </form>

                </div>

            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    var deleteModal = document.getElementById('deleteModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');

        var form = document.getElementById('deleteForm');
        form.action = "/admin/book_management/delete_book/" + id;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    var unPublishModal = document.getElementById('unPublishModal');

    unPublishModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');

        var form = document.getElementById('unPublishForm');
        form.action = "/admin/book_management/unpublish_book/" + id;
    });
});
</script>
<?= $this->endSection() ?>