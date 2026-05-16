<div class="app-sidebar bg-dark-dark-brown shadow-lg">
    <div class="sidebar-brand">
        <a href="/admin/dashboard" class="navbar-brand">
            <span class="fw-bold text-white">
                <i class="bi bi-book me-2"></i> LibraGo
            </span>
        </a>
    </div>
    <div class="p-2 text-center text-white">
        <span class="fw-bold">Library ID: </span><?= session()->get('library_id'); ?> <br>
        <span class="fw-bold">Name: </span><?= session()->get('name'); ?>
    </div>
    <hr class="bg-white">
    <div class="sidebar-wrapper">
        <ul class="nav sidebar-menu flex-column">
            <li class="nav-item mb-2">
                <a href="/admin/dashboard" class="nav-link text-white px-3 py-2">
                    Dashboard
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/users" class="nav-link text-white px-3 py-2">
                    Users
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/book_management_active" class="nav-link text-white px-3 py-2">
                    Book Management
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/borrowed_books/borrowed" class="nav-link text-white px-3 py-2">
                    Borrowed Books
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/borrow_requests/pending_borrow_requests" class="nav-link text-white px-3 py-2">
                    Borrow Requests
                </a>
            </li>
            <!-- <li class="nav-item">
                <a href="#" class="nav-link text-white px-3 py-2">
                    Reservations
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white px-3 py-2">
                    Transactions
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white px-3 py-2">
                    Reports
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link text-white px-3 py-2">
                    Audit Trails
                </a>
            </li> -->
            <li class="nav-item">
                <a href="/admin/unpaid_fines_list" class="nav-link text-white px-3 py-2">
                    Fines
                </a>
            </li>
            <li class="nav-item">
                <a href="/admin/library_settings" class="nav-link text-white px-3 py-2">
                    Settings
                </a>
            </li>
            <li class="nav-item">
                <a href="<?= base_url('logout') ?>" class="nav-link text-danger px-3 py-2">
                    Logout
                </a>
            </li>
        </ul>
    </div>
</div>