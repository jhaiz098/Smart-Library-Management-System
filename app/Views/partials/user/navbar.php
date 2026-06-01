<div class="app-sidebar bg-dark-dark-brown shadow-lg d-flex flex-column" style="min-height:100vh; width:260px;">

    <!-- BRAND -->
    <div class="sidebar-brand p-3 border-bottom border-white border-opacity-25">
        <a href="/admin/dashboard" class="navbar-brand text-decoration-none d-flex align-items-center gap-2">
            <i class="bi bi-book text-white fs-4"></i>
            <span class="fw-bold text-white fs-5">LibraGo</span>
        </a>
    </div>

    <!-- USER INFO -->
    <div class="p-3 text-center text-white border-bottom border-white border-opacity-25">

        <!-- INITIALS AVATAR -->
        <div class="mx-auto mb-2 d-flex align-items-center justify-content-center"
            style="
                width: 48px;
                height: 48px;
                border-radius: 50%;
                background: rgba(255,255,255,0.15);
                border: 1px solid rgba(255,255,255,0.25);
                font-weight: 700;
                font-size: 16px;
            ">
            <?= strtoupper(substr(session()->get('name') ?? '', 0, 1)) ?>
        </div>

        <div class="fw-semibold small text-uppercase opacity-75">
            Library User
        </div>

        <div class="fw-bold mt-1">
            <?= session()->get('name'); ?>
        </div>

        <!-- EMAIL -->
        <div class="small opacity-75 mt-1">
            <?= session()->get('email'); ?>
        </div>

        <!-- ID -->
        <div class="small opacity-75">
            ID: <?= session()->get('library_id'); ?>
        </div>

    </div>

    <!-- MENU -->
    <div class="sidebar-wrapper flex-grow-1 p-2">

        <ul class="nav flex-column gap-1">

            <li class="nav-item">
                <a href="/user/dashboard"
                   class="nav-link text-white px-3 py-2 rounded sidebar-link">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item">
                <a href="/user/books"
                   class="nav-link text-white px-3 py-2 rounded sidebar-link">
                    <i class="bi bi-journal-bookmark me-2"></i> Books
                </a>
            </li>

            <li class="nav-item">
                <a href="/user/my_transactions/borrowings"
                   class="nav-link text-white px-3 py-2 rounded sidebar-link">
                    <i class="bi bi-receipt me-2"></i> My Transactions
                </a>
            </li>

            <li class="nav-item">
                <a href="/user/overdue/list"
                   class="nav-link text-white px-3 py-2 rounded sidebar-link">
                    <i class="bi bi-exclamation-triangle me-2"></i> Overdue
                </a>
            </li>

            <li class="nav-item">
                <a href="/user/fines/unpaid"
                   class="nav-link text-white px-3 py-2 rounded sidebar-link">
                    <i class="bi bi-cash-coin me-2"></i> Fines
                </a>
            </li>

            <li class="nav-item">
                <a href="/user/profile"
                   class="nav-link text-white px-3 py-2 rounded sidebar-link">
                    <i class="bi bi-person me-2"></i> Profile
                </a>
            </li>

            <li class="nav-item">
                <a href="/user/help"
                   class="nav-link text-white px-3 py-2 rounded sidebar-link">
                    <i class="bi bi-question-circle me-2"></i> Help / FAQ
                </a>
            </li>

        </ul>

    </div>

    <!-- LOGOUT -->
    <div class="p-3 border-top border-white border-opacity-25">
        <a href="<?= base_url('logout') ?>"
           class="btn btn-outline-light w-100">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </a>
    </div>

</div>

<!-- STYLE (keeps YOUR color system) -->
<style>
    .bg-dark-dark-brown {
        background: #2b1d14; /* keep your theme */
    }

    .sidebar-link {
        transition: 0.2s ease;
        opacity: 0.85;
        font-size: 14px;
    }

    .sidebar-link:hover {
        background: rgba(255, 255, 255, 0.08);
        opacity: 1;
        transform: translateX(3px);
    }

    .sidebar-link.active {
        background: rgba(255, 255, 255, 0.15);
        opacity: 1;
        font-weight: 600;
    }

    .sidebar-wrapper {
        overflow-y: auto;
    }
</style>