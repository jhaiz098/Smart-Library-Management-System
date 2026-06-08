<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Setting
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Settings
<?= $this->endSection() ?>

<?= $this->section('content') ?>

    <div class="p-3">
        <div class="card border-0 shadow-sm">
            <!-- HEADER -->
            <div class="card-header d-flex justify-content-between align-items-center">

                <div>

                    <h5 class="fw-bold mb-1">
                        Category Management
                    </h5>

                    <div class="text-muted small">
                        Organize and manage book categories used throughout the library collection
                    </div>

                </div>

            </div>

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

                    <div class="card-body">
                        <!-- SEARCH + FILTER -->
                        <div class="filter-toolbar">

                            <form method="get"
                                action="<?= current_url() ?>"
                                class="row g-2 align-items-center">

                                <!-- SEARCH -->
                                <div class="col-md-8">

                                    <div class="search-box">

                                        <i class="bi bi-search"></i>

                                        <input
                                            type="search"
                                            name="search"
                                            class="form-control"
                                            placeholder="Search category..."
                                            value="<?= $_GET['search'] ?? '' ?>"
                                        >

                                    </div>

                                </div>

                                <!-- SEARCH BUTTON -->
                                <div class="col-md-2">

                                    <button class="btn btn-primary w-100">
                                        Search
                                    </button>

                                </div>

                                <!-- SORT -->
                                <div class="col-md-2">

                                    <select
                                        name="sort"
                                        class="form-select filter-select"
                                        onchange="this.form.submit()">

                                        <option value="">Sort By</option>

                                        <option value="name_asc"
                                            <?= ($sort ?? '') == 'name_asc' ? 'selected' : '' ?>>
                                            Name Ascending
                                        </option>

                                        <option value="name_desc"
                                            <?= ($sort ?? '') == 'name_desc' ? 'selected' : '' ?>>
                                            Name Descending
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

                            </form>

                        </div>
                        <!-- SEARCH / FILTER -->
                        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-3">
                            <button class="btn btn-primary btn-sm px-3 py-2 my-2"
                                data-bs-toggle="modal"
                                data-bs-target="#categoryModal"
                                onclick="openAddModal()">
                                + Add Category
                            </button>
                        </div>

                        <!-- TABLE -->
                        <?php
                        $currentPage = $pager->getCurrentPage();
                        $perPage = 10;

                        $i = (($currentPage - 1) * $perPage) + 1;
                        ?>

                        <div class="table-responsive">

                            <table class="table table-hover align-middle mb-0 fs-7">

                                <thead class="table-light text-uppercase">

                                    <tr>

                                        <th>#</th>
                                        <th>Category Name</th>
                                        <th>Created</th>
                                        <th>Updated</th>
                                        <th>Actions</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <?php if(empty($categories)): ?>

                                        <tr>

                                            <td colspan="5"
                                                class="text-center text-muted py-4">

                                                No categories found.

                                            </td>

                                        </tr>

                                    <?php else: ?>

                                        <?php foreach($categories as $cat): ?>

                                            <tr>

                                                <!-- NUMBER -->
                                                <td>

                                                    <?= $i++ ?>

                                                </td>

                                                <!-- CATEGORY -->
                                                <td>

                                                    <div>

                                                        <?= esc($cat['name']) ?>

                                                    </div>

                                                </td>

                                                <!-- CREATED -->
                                                <td>

                                                    <?= date(
                                                        'M d, Y',
                                                        strtotime($cat['created_at'])
                                                    ) ?>

                                                </td>

                                                <!-- UPDATED -->
                                                <td>

                                                    <?= date(
                                                        'M d, Y',
                                                        strtotime($cat['updated_at'])
                                                    ) ?>

                                                </td>

                                                <!-- ACTIONS -->
                                                <td>
                                                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle"
                                                            data-bs-toggle="dropdown">
                                                        <i class="bi bi-gear-fill me-1"></i>
                                                        Actions
                                                    </button>

                                                    <ul class="dropdown-menu">

                                                        <li>
                                                            <button class="dropdown-item">
                                                                <i class="bi bi-pencil-square me-2"></i>
                                                                Edit
                                                            </button>
                                                        </li>

                                                        <li>
                                                            <button class="dropdown-item text-danger">
                                                                <i class="bi bi-trash me-2"></i>
                                                                Delete
                                                            </button>
                                                        </li>

                                                    </ul>
                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                        <div class="mt-3 d-flex justify-content-center">
                            <?= $pager->links('default', 'bootstrap_full') ?>
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
<style>
    .table tbody tr:hover {
        background: #f8f9fa;
    }
    .filter-toolbar{
        background: #fff;
        padding: 14px;
        border: 1px solid #e9ecef;
        border-radius: 14px;
    }

    .search-box{
        position: relative;
    }

    .search-box i{
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 2;
    }

    .search-box .form-control{
        padding-left: 40px;
        border-radius: 10px;
        border: 1px solid #dee2e6;
        height: 42px;
    }

    .filter-select{
        border-radius: 10px;
        height: 42px;
    }

    .filter-select:focus,
    .search-box .form-control:focus{
        border-color: #86b7fe;
        box-shadow: 0 0 0 .15rem rgba(13,110,253,.15);
    }

    .filter-toolbar .btn-primary{
        height: 42px;
        border-radius: 10px;
        font-weight: 600;
    }
</style>
<?= $this->endSection() ?>