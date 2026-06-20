<?= $this->extend('layouts/book_management_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Book Management
<?= $this->endSection() ?>

<?= $this->section('render_books') ?>

<div class="card">
    <div class="card-body table-responsive">

        <p class="fs-6 fw-bold">Draft Books</p>
        <table class="table table-bordered fs-7">
            <tr class="text-center">
                <th>ID</th>
                <th>Category</th>
                <th>Title</th>
                <th>Author</th>
                <th>Description</th>
                <th>Published Year</th>
                <th>Publisher</th>
                <th>Availability</th>
                <th>Created at</th>
                <th>Updated at</th>
                <th colspan="3">Action</th>
            </tr>
            <?php if (empty($draft_books)): ?>
                <tr>
                    <td colspan="10" class="text-center">No books available</td>
                </tr>

            <?php else: ?>

                <?php foreach ($draft_books as $book): ?>
                    <tr>
                        <td><?= $book['id'] ?></td>
                        <td><?= $book['category_name'] ?></td>
                        <td><?= $book['title'] ?></td>
                        <td><?= $book['author'] ?></td>
                        <td><?= $book['description'] ?></td>
                        <td><?= $book['published_year'] ?></td>
                        <td><?= $book['publisher'] ?></td>
                        <td><?= $book['availability'] ?></td>
                        <td><?= $book['created_at'] ?></td>
                        <td><?= $book['updated_at'] ?></td>
                        <td>
                            <a href="/admin/book_management/edit_book/<?= $book['id'] ?>" class="btn btn-sm btn-secondary fs-7">
                                Edit
                            </a>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-danger fs-7" data-bs-toggle="modal" data-bs-target="#deleteModal" data-id="<?= $book['id'] ?>">
                                Delete
                            </button>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-success fs-7" data-bs-toggle="modal" data-bs-target="#publishModal" data-id="<?= $book['id'] ?>">
                                Publish
                            </button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <div class="mt-3 d-flex justify-content-center">
            <?= $draft_pager
                ->only(['search', 'sort', 'category'])
                ->links('draft', 'bootstrap_full') ?>
        </div>
    </div>
</div>

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                
                <div class="modal-header">
                    <h5 class="modal-title">Delete Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this book?
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
                    <h5 class="modal-title">Publish Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to publish this book?
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