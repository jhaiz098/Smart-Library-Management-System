<?= $this->extend('layouts/book_management_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Book Management
<?= $this->endSection() ?>

<?= $this->section('render_books') ?>

<div class="card">
    <div class="table-responsive">

        <table class="table table-hover align-middle">

            <thead class="table-light">

                <tr class="text-muted small text-uppercase">

                    <th style="width:60px;">#</th>
                    <th>Category</th>
                    <th>Book</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>Created</th>
                    <th>Actions</th>

                </tr>

            </thead>

            <tbody>

                <?php if(empty($draft_books)): ?>

                    <tr>

                        <td colspan="9" class="text-center text-muted py-4">
                            No draft books available
                        </td>

                    </tr>

                <?php else: ?>

                    <?php $i = 1; ?>

                    <?php foreach($draft_books as $book): ?>

                        <tr>

                            <td class="text-muted fw-semibold">
                                <?= $i++ ?>
                            </td>

                            <td>

                                <span class="badge bg-light text-dark border rounded-pill px-3 py-2">
                                    <?= esc($book['category_name']) ?>
                                </span>

                            </td>

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

                            <td class="text-muted">
                                <?= esc($book['author']) ?>
                            </td>

                            <td class="text-muted">
                                <?= esc($book['publisher']) ?>
                            </td>

                            <td>
                                <?= esc($book['published_year']) ?>
                            </td>

                            <td class="small text-muted">

                                <?= date('M d, Y', strtotime($book['created_at'])) ?>

                            </td>

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
                                                href="/admin/book_management/edit_book/<?= $book['id'] ?>"
                                                class="dropdown-item"
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
                                                class="dropdown-item text-success"
                                                data-bs-toggle="modal"
                                                data-bs-target="#publishModal"
                                                data-id="<?= $book['id'] ?>"
                                            >
                                                Publish
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

        <?= $draft_pager
            ->only(['search', 'sort', 'category'])
            ->links('draft', 'bootstrap_full') ?>

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
                        Are you sure you want to permanently delete this book?
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

    <div class="modal fade" id="publishModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">

                    <h5 class="modal-title text-success">
                        Publish Book
                    </h5>

                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="modal">
                    </button>

                </div>

                <div class="modal-body">

                    <p>
                        Are you sure you want to publish this book?
                    </p>

                    <div class="alert alert-success mb-0">
                        The book will become visible and available in the library collection.
                    </div>

                </div>
                <div class="modal-footer">

                    <form id="publishForm" method="post">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>

                        <button type="submit" class="btn btn-success">
                            Yes, Publish
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
                    <h5 class="modal-title">Unpublish Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to unpublish this book?
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
    var publishModal = document.getElementById('publishModal');

    publishModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');

        var form = document.getElementById('publishForm');
        form.action = "/admin/book_management/publish_book/" + id;
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