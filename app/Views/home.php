
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body class="sidebar-collapse layout-fixed sidebar-expand-lg">
    
<div class="app-wrapper">
    
    <!-- HEADER -->
    <header class="app-header navbar navbar-expand-sm navbar-dark bg-dark-dark-brown">
        <div class="container-fluid d-flex justify-content-between">
            <div class="d-flex align-items-center">
                <a href="#" class="btn btn-link text-white fs-5 d-sm-none" data-lte-toggle="sidebar"><i class="bi bi-list"></i></a>

                <a href="#" class="ms-3 navbar-brand">
                    <span class="fw-bold">
                        <i class="bi bi-book me-2"></i> LibraGo
                    </span>
                </a>
            </div>

            <div>
                <ul class="navbar-nav d-sm-flex d-none ms-auto">
                    <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="/register" class="nav-link">Register</a></li>
                </ul>
            </div>
        </div>
    </header>

    <div class="app-sidebar d-lg-none bg-dark-dark-brown">
        <div class="sidebar-wrapper">
            <ul class="nav sidebar-menu flex-column">
                <li class="nav-item mb-2">
                    <a href="#" class="nav-link text-white px-3 py-2">
                        Login
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link text-white px-3 py-2">
                        Register
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <div class="app-main pb-0">
        
        <div class="bg-library">
            <div class="front text-white">
                <div class="container text-center pt-5 pb-3">
                    
                    <!-- HERO -->
                    <h1 class="hero-title">LibraGo</h1>

                    <p class="hero-sub">
                        Smart Library Reservation and Borrowing Management System
                    </p>

                    <p>
                        Search books, submit borrow requests, reserve unavailable books,
                        and manage your library activities online.
                    </p>

                    <a href="/login" class="btn btn-lg text-white m-5 bg-dark-brown">
                        Get Started
                    </a>
                
                    <!-- FEATURES -->

                    <h2 class="text-center mb-3 mt-3">
                        User Features
                    </h2>

                    <div class="row">

                        <div class="col-md-4">
                            <div class="card mb-2 shadow-lg">
                                <div class="card-body p-4">
                                    <h5>
                                        <i class="bi bi-journal-check me-2"></i>
                                        Borrow Requests
                                    </h5>

                                    <p>
                                        Request available books and wait for staff approval.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-2 shadow-lg">
                                <div class="card-body p-4">
                                    <h5>
                                        <i class="bi bi-people me-2"></i>
                                        Reservation Queue
                                    </h5>

                                    <p>
                                        Reserve unavailable books and automatically join the queue.
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-2 shadow-lg">
                                <div class="card-body p-4">
                                    <h5>
                                        <i class="bi bi-clock-history me-2"></i>
                                        Track Requests
                                    </h5>

                                    <p>
                                        Monitor request status, reservations, and borrowing history.
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

        <!-- HOW IT WORKS -->
        <section class="front bg-light text-dark">

            <div class="container">

                <h2 class="text-center mt-5 mb-3">
                    How It Works
                </h2>

                <div class="row text-center">

                    <div class="col-md-3">
                        <div class="card shadow-sm p-3 mb-3 bg-light-brown-yellow">
                            <div class="card-body">
                                <i class="bi bi-person-plus fs-1 text-dark-brown"></i>

                                <h5>1. Register</h5>

                                <p>
                                    Create your library account.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm p-3 mb-3 bg-light-brown-yellow">
                            <div class="card-body">
                                <i class="bi bi-search fs-1 text-dark-brown"></i>

                                <h5>2. Find Books</h5>

                                <p>
                                    Search books in the library catalog.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm p-3 mb-3 bg-light-brown-yellow">
                            <div class="card-body">
                                <i class="bi bi-journal-arrow-up fs-1 text-dark-brown"></i>

                                <h5>3. Submit Request</h5>

                                <p>
                                    Send a borrow request or reserve the book.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="card shadow-sm p-3 mb-3 bg-light-brown-yellow">
                            <div class="card-body">
                                <i class="bi bi-check-circle fs-1 text-dark-brown"></i>

                                <h5>4. Claim Book</h5>

                                <p>
                                    Visit the library and claim approved requests.
                                </p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </section>

        <!-- STATISTICS -->
        <section class="front py-5 bg-light-yellow">

            <div class="container">

                <div class="row text-center">

                    <div class="col-md-3">
                        <h2 class="fw-bold text-dark-brown">
                            <?= $total_books ?? '1000+' ?>
                        </h2>

                        <p class="text-muted">
                            Books Available
                        </p>
                    </div>

                    <div class="col-md-3">
                        <h2 class="fw-bold text-dark-brown">
                            <?= $total_members ?? '500+' ?>
                        </h2>

                        <p class="text-muted">
                            Library Members
                        </p>
                    </div>

                    <div class="col-md-3">
                        <h2 class="fw-bold text-dark-brown">
                            <?= $total_borrowed ?? '300+' ?>
                        </h2>

                        <p class="text-muted">
                            Books Borrowed
                        </p>
                    </div>

                    <div class="col-md-3">
                        <h2 class="fw-bold text-dark-brown">
                            <?= $total_reservations ?? '150+' ?>
                        </h2>

                        <p class="text-muted">
                            Reservations
                        </p>
                    </div>

                </div>

            </div>

        </section>
    </div>

    <div class="app-footer text-center text-white bg-dark-dark-brown">
        <strong>LibraGo</strong> - 2026
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/js/adminlte.min.js"></script>

</body>
</html>