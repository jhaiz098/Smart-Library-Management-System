<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Setting
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Settings
<?= $this->endSection() ?>

<?= $this->section('content') ?>


    <div class="p-3">
        <div class="card">
            <div class="card-header fw-bold">Settings</div>
            <div class="card-body">
                <?= view('partials/admin/settings_nav') ?>

                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success mt-3">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if(session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger mt-3">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <div class="card mt-3">
                    <div class="card-header fw-bold d-flex justify-content-between align-items-center">
                        <span>Category Management</span>
                    </div>

                    <div class="card-body">
                        <!-- SEARCH / FILTER -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#categoryModal"
                                onclick="openAddModal()">
                                + Add Category
                            </button>

                            <div class="text-muted small">
                                Total Categories: <?= $categories_count ?>
                            </div>

                            <form method="get" action="<?= current_url() ?>" class="d-flex gap-2">

                                <input
                                    type="search"
                                    name="search"
                                    class="form-control"
                                    placeholder="Search category..."
                                    value="<?= $_GET['search'] ?? '' ?>"
                                >

                                <input type="submit" class="btn btn-secondary" value="Search">

                                <!-- SORT -->
                                <select name="sort" class="form-select" onchange="this.form.submit()">
                                    <option value="">Sort By</option>
                                    <option value="name_asc" <?= ($sort ?? '') == 'name_asc' ? 'selected' : '' ?>>A-Z</option>
                                    <option value="name_desc" <?= ($sort ?? '') == 'name_desc' ? 'selected' : '' ?>>Z-A</option>
                                    <option value="newest" <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>Newest</option>
                                    <option value="oldest" <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>Oldest</option>
                                </select>
                            </form>
                        </div>

                        <!-- TABLE -->
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle fs-7">
                                <tr class="text-center">
                                    <th width="80">ID</th>
                                    <th>Category Name</th>
                                    <th width="180">Created At</th>
                                    <th width="180">Updated At</th>
                                    <th colspan="2">Actions</th>
                                </tr>
                                <?php if(!$categories): ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">
                                            No categories found
                                        </td>
                                    </tr>
                                <?php else: ?>
                                    <?php foreach($categories as $cat): ?>
                                        <tr>
                                            <td><?= $cat['id'] ?></td>
                                            <td><?= $cat['name'] ?></td>
                                            <td><?= $cat['created_at'] ?></td>
                                            <td><?= $cat['updated_at'] ?></td>
                                            <td>
                                                <button class="w-100 btn btn-sm btn-secondary"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#categoryModal"
                                                    onclick="openEditModal(<?= $cat['id'] ?>, '<?= esc($cat['name']) ?>')">
                                                    Edit
                                                </button>
                                            </td>
                                            <td>
                                                <button 
                                                    class="w-100 btn btn-sm btn-danger"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#deleteCategoryModal"
                                                    data-id="<?= $cat['id'] ?>"
                                                >
                                                    Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                
                            </table>

                            <div class="mt-3 d-flex justify-content-center">
                                <?= $pager->links('default', 'bootstrap_full') ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="modal fade" id="categoryModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <form id="categoryForm" method="post">

                        <div class="modal-header">
                            <h5 class="modal-title" id="modalTitle">Add Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">

                            <input type="hidden" name="id" id="categoryId">

                            <div class="mb-3">
                                <label class="form-label">Category Name</label>
                                <input type="text" name="name" id="categoryName" class="form-control" required>
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                Cancel
                            </button>

                            <button type="submit" class="btn btn-primary" id="submitBtn">
                                Save
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

        <div class="modal fade" id="deleteCategoryModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Delete Category</h5>

                        <button 
                            type="button" 
                            class="btn-close" 
                            data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        Are you sure you want to delete this category?
                    </div>

                    <div class="modal-footer">

                        <form id="deleteCategoryForm" method="post">

                            <button 
                                type="button" 
                                class="btn btn-secondary" 
                                data-bs-dismiss="modal"
                            >
                                Cancel
                            </button>

                            <button 
                                type="submit" 
                                class="btn btn-danger"
                            >
                                Yes, Delete
                            </button>

                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').innerText = "Add Category";
    document.getElementById('categoryForm').action = "<?= site_url('admin/category_management_settings/add_category') ?>";
    document.getElementById('categoryId').value = "";
    document.getElementById('categoryName').value = "";
}

function openEditModal(id, name) {
    document.getElementById('modalTitle').innerText = "Edit Category";
    document.getElementById('categoryForm').action = "<?= site_url('admin/category_management_settings/update_category') ?>";

    document.getElementById('categoryId').value = id;
    document.getElementById('categoryName').value = name;
}

document.addEventListener('DOMContentLoaded', function () {

    var deleteModal = document.getElementById('deleteCategoryModal');

    deleteModal.addEventListener('show.bs.modal', function (event) {

        var button = event.relatedTarget;

        var id = button.getAttribute('data-id');

        var form = document.getElementById('deleteCategoryForm');

        form.action = "/admin/category_management_settings/delete_category/" + id;

    });

});
</script>

<?= $this->endSection() ?>