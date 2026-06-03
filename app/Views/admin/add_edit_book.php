<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Add Book
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    <?= (isset($book)) ? 'Edit' : 'Add' ?> Book
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white d-flex justify-content-between align-items-center">

                    <div>

                        <div class="fw-bold fs-5">
                            <?= isset($book) ? 'Edit Book' : 'Add Book' ?>
                        </div>

                        <div class="text-muted small">
                            <?= isset($book)
                                ? 'Update book information'
                                : 'Create a new book record' ?>
                        </div>

                    </div>

                    <a href="/admin/book_management_active"
                       class="btn btn-outline-secondary btn-sm">
                        Back
                    </a>

                </div>

                <div class="card-body">

                    <?php if(session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form method="post"
                          action="/admin/book_management/save_book">

                        <div class="row g-3">

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Category
                                </label>

                                <select name="category_id"
                                        class="form-select">

                                    <?php foreach ($categories as $category): ?>

                                        <?php
                                        $selected =
                                            (isset($book)
                                            && $book['category_id'] == $category['id'])
                                            ? 'selected'
                                            : '';
                                        ?>

                                        <option value="<?= $category['id'] ?>"
                                                <?= $selected ?>>
                                            <?= esc($category['name']) ?>
                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Published Year
                                </label>

                                <select name="published_year"
                                        class="form-select">

                                    <?php
                                    $currentYear = date('Y');

                                    for ($y = $currentYear; $y >= 1900; $y--):

                                        $selected =
                                            (isset($book)
                                            && $book['published_year'] == $y)
                                            ? 'selected'
                                            : '';
                                    ?>

                                        <option value="<?= $y ?>"
                                                <?= $selected ?>>
                                            <?= $y ?>
                                        </option>

                                    <?php endfor; ?>

                                </select>

                            </div>

                            <div class="col-12">

                                <label class="form-label fw-semibold">
                                    Title
                                </label>

                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       value="<?= $book['title'] ?? '' ?>"
                                       required>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Author
                                </label>

                                <input type="text"
                                       name="author"
                                       class="form-control"
                                       value="<?= $book['author'] ?? '' ?>"
                                       required>

                            </div>

                            <div class="col-md-6">

                                <label class="form-label fw-semibold">
                                    Publisher
                                </label>

                                <input type="text"
                                       name="publisher"
                                       class="form-control"
                                       value="<?= $book['publisher'] ?? '' ?>"
                                       required>

                            </div>

                            <div class="col-12">

                                <label class="form-label fw-semibold">
                                    Description
                                </label>

                                <textarea name="description"
                                          rows="5"
                                          class="form-control"
                                          required><?= $book['description'] ?? '' ?></textarea>

                            </div>

                            

                        </div>

                        <input type="hidden"
                               name="id"
                               value="<?= $book['id'] ?? '' ?>">

                        <hr>

                        <div class="d-flex justify-content-end gap-2">

                            <button type="reset"
                                    class="btn btn-light border">
                                Reset
                            </button>

                            <button type="submit"
                                    class="btn btn-primary">
                                <?= isset($book)
                                    ? 'Save Changes'
                                    : 'Add Book' ?>
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>