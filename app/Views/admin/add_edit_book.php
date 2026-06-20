<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Add Book
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <?= (isset($book)) ? 'Edit' : 'Add' ?> Book
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">
    <a href="/admin/book_management" class="btn btn-secondary">Back</a>

    <div class="card mt-3">
        <div class="card-header fw-bold"><?= (isset($book)) ? 'Edit' : 'Add' ?> Book Form</div>
        <div class="card-body">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>
            <form method="post" action="/admin/book_management/save_book">
                <label class="me-2">Category</label><select name="category_id" class="form-select">
                                                        <?php foreach ($categories as $category): ?>

                                                            <?php 
                                                                $selected = (isset($book) && $book['category_id'] == $category['id']) ? 'selected' : '';
                                                            ?>

                                                            <option value="<?= $category['id'] ?>" <?= $selected ?>>
                                                                <?= $category['name'] ?>
                                                            </option>

                                                        <?php endforeach; ?>
                                                    </select>
                <label class="me-2">Title</label><input name="title" class="form-control mb-3" type="text" value="<?= $book['title'] ?? '' ?>" required>
                <label class="me-2">Author</label><input name="author" class="form-control mb-3" type="text" value="<?= $book['author'] ?? '' ?>" required>
                <label class="me-2">Description</label><textarea name="description" class="form-control mb-3" name="w3review" rows="4" cols="50" required><?= $book['description'] ?? '' ?></textarea>
                <label class="me-2">Published Year</label><select name="published_year" class="form-select mb-3">
                                                            <?php
                                                            $currentYear = date('Y');
                                                            for ($y = $currentYear; $y >= 1900; $y--) {
                                                                $selected = (isset($book) && $book['published_year'] == $y) ? 'selected' : '';
                                                                echo "<option value='$y' $selected>$y</option>";
                                                            }
                                                            ?>
                                                        </select>
                <label class="me-2">Publisher</label><input name="publisher" class="form-control mb-3" type="text" value="<?= $book['publisher'] ?? '' ?>" required>
                <label class="me-2">Status</label><select name="status" class="form-select mb-3">
                                                        <option value="draft"
                                                            <?= (isset($book) && $book['status'] == 'draft') ? 'selected' : '' ?>>Draft</option>
                                                        <option value="active"
                                                            <?= (isset($book) && $book['status'] == 'active') ? 'selected' : '' ?>>Active</option>
                </select>

                <input type="hidden" name="id" value="<?= $book['id'] ?? '' ?>">

                <input type="reset" value="Reset" class="btn btn-secondary">
                <input type="submit" value="Submit" class="btn btn-primary">
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>