<form
    method="get"
    action="<?= current_url() ?>"
    class="row g-2"
>

    <input
        type="hidden"
        name="type"
        value="<?= $request_status ?? 'all' ?>"
    >

    <div class="col-md-8">

        <input
            type="search"
            name="search"
            class="form-control"
            placeholder="Search request code, borrower, library ID, or book title..."
            value="<?= $_GET['search'] ?? '' ?>"
        >

    </div>

    <div class="col-md-2">

        <button
            type="submit"
            class="btn btn-primary w-100"
        >
            Search
        </button>

    </div>

    <div class="col-md-2">

        <select
            name="sort"
            class="form-select"
            onchange="this.form.submit()"
        >

            <option value="">Sort By</option>

            <option value="newest"
                <?= ($sort ?? '') == 'newest' ? 'selected' : '' ?>>
                Recently Requested
            </option>

            <option value="oldest"
                <?= ($sort ?? '') == 'oldest' ? 'selected' : '' ?>>
                Earliest Requested
            </option>

            <option value="code_asc"
                <?= ($sort ?? '') == 'code_asc' ? 'selected' : '' ?>>
                Request Code Ascending
            </option>

            <option value="code_desc"
                <?= ($sort ?? '') == 'code_desc' ? 'selected' : '' ?>>
                Request Code Descending
            </option>

        </select>

    </div>

</form>