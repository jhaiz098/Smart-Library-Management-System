<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Books
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Books
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>
    <div class="card">
        <div class="card-header fw-bold">Books List</div>
        <div class="card-body">

            <table class="table table-bordered fs-7">
                <tr>
                    <th>Category</th>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Description</th>
                    <th>Availability</th>
                    <th>Published Year</th>
                    <th>Publisher</th>
                    <th>Action</th>
                </tr>
                <?php if(empty($books)): ?>
                    <tr>
                        <td colspan="10" class="text-center">No books available</td>
                    </tr>
                <?php else: ?>
                    <?php foreach($books as $book): ?>
                        <tr>
                            <td><?= $book['category_name'] ?></td>
                            <td><?= $book['title'] ?></td>
                            <td><?= $book['author'] ?></td>
                            <td><?= $book['description'] ?></td>
                            <td><?= $book['availability'] ?></td>
                            <td><?= $book['published_year'] ?></td>
                            <td><?= $book['publisher'] ?></td>
                            <td><a href="books/view/<?= $book['id'] ?>" class="btn btn-sm btn-primary">View</a></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>

        </div>
    </div>

</div>

<?= $this->endSection() ?>