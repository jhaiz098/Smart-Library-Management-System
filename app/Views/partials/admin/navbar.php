<div class="app-sidebar bg-admin-dark shadow-lg d-flex flex-column"
     style="min-height:100vh; width:260px;">

    <!-- BRAND -->
    <div class="sidebar-brand p-3 border-bottom border-white border-opacity-10">
        <a href="/admin/dashboard"
           class="navbar-brand text-decoration-none d-flex align-items-center gap-2">

            <i class="bi bi-shield-lock-fill text-info fs-4"></i>

            <span class="fw-bold text-white fs-5">
                LibraGo Admin
            </span>

        </a>
    </div>

    <!-- ADMIN INFO -->
    <div class="p-3 text-center text-white border-bottom border-white border-opacity-10">

        <!-- AVATAR -->
        <div class="mx-auto mb-2 d-flex align-items-center justify-content-center admin-avatar">
            <?= strtoupper(substr(session()->get('name') ?? '', 0, 1)) ?>
        </div>

        <div class="fw-semibold small text-uppercase opacity-75">
            <?php if(session()->get('role_id') == 1): ?>
                    Administrator
            <?php elseif(session()->get('role_id') == 2): ?>
                    Staff | <?= session()->get('staff_level_name') ?>
            <?php endif; ?>
        </div>

        <div class="fw-bold mt-1">
            <?= session()->get('name'); ?>
        </div>

        <div class="small opacity-75 mt-1">
            <?= session()->get('email'); ?>
        </div>

        <div class="small opacity-75">
            ID: <?= session()->get('library_id'); ?>
        </div>

    </div>

    <!-- MENU -->
    <div class="sidebar-wrapper flex-grow-1 p-2">

        <ul class="nav flex-column gap-1">

            <li class="nav-item">
                <a href="/admin/dashboard"
                   class="nav-link sidebar-link text-white rounded">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/users"
                   class="nav-link sidebar-link text-white rounded">
                    <i class="bi bi-people-fill me-2"></i> User Management
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/book_management_active"
                   class="nav-link sidebar-link text-white rounded">
                    <i class="bi bi-journal-bookmark-fill me-2"></i> Book Management
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/borrowed_books/borrowed"
                   class="nav-link sidebar-link text-white rounded">
                    <i class="bi bi-arrow-left-right me-2"></i> Borrowed Books
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/borrow_requests/pending_borrow_requests"
                   class="nav-link sidebar-link text-white rounded">
                    <i class="bi bi-inbox-fill me-2"></i> Borrow Requests
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/unpaid_fines_list"
                   class="nav-link sidebar-link text-white rounded">
                    <i class="bi bi-cash-coin me-2"></i> Fines
                </a>
            </li>

            <li class="nav-item">
                <a href="/admin/library_settings"
                   class="nav-link sidebar-link text-white rounded">
                    <i class="bi bi-gear-fill me-2"></i> Settings
                </a>
            </li>

        </ul>

    </div>

    <!-- LOGOUT -->
    <div class="p-3 border-top border-white border-opacity-10">
        <a href="<?= base_url('logout') ?>"
           class="btn btn-outline-info w-100">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </a>
    </div>

</div>

<!-- STYLES -->
<style>

    /* ADMIN THEME (DIFFERENT FROM USER) */
    .bg-admin-dark {
        background: #111827; /* slate-900 style */
    }

    .sidebar-link {
        padding: 10px 12px;
        font-size: 14px;
        opacity: 0.85;
        transition: 0.2s ease;
        display: flex;
        align-items: center;
    }

    .sidebar-link:hover {
        background: rgba(13, 202, 240, 0.12);
        color: #0dcaf0 !important;
        opacity: 1;
        transform: translateX(3px);
    }

    .sidebar-link.active {
        background: rgba(13, 202, 240, 0.18);
        color: #0dcaf0 !important;
        font-weight: 600;
        border-left: 3px solid #0dcaf0;
    }

    .admin-avatar {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: rgba(13, 202, 240, 0.15);
        border: 1px solid rgba(13, 202, 240, 0.35);
        font-weight: 700;
        font-size: 16px;
        color: #0dcaf0;
    }

</style>