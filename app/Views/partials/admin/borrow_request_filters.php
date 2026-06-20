<div class="d-flex justify-content-end align-items-center mb-3 flex-wrap gap-2">
    <!-- LEFT SIDE -->
    <!-- <div>
        <a class="btn btn-primary fs-7" href="/admin/book_management/add_book">
            + Add Book
        </a>
    </div> -->

    <!-- RIGHT SIDE -->
    <div class="d-flex align-items-center gap-2 flex-wrap">
        <!-- SEARCH -->
        <form method="get" action="<?= current_url() ?>" class="d-flex gap-2">

            <input
                type="search"
                name="search"
                placeholder="Search title..."
                class="form-control"
                value=""
            >

            <button type="submit" class="btn btn-secondary">
                Search
            </button>

            <!-- SORT -->
            <select name="sort" class="form-select" onchange="this.form.submit()">
                <option value="">Sort By</option>
            </select>

            <!-- FILTER -->
            <select name="category" class="form-select" onchange="this.form.submit()">
                <option value="">All Categories</option>
            </select>
        </form>
    </div>
</div>