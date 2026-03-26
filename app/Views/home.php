<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibraGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    
    <style>
        .bg-library {
            /* min-height:100vh; */
            background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da') no-repeat center center/cover;
        }

        .bg-library:before {
            content:"";
            position:absolute;
            width:100%;
            height:100%;
            background: rgba(60, 40, 20, 0.75);
            top:0;
            left:0;
        }

        .content {
            position:relative;
            z-index: 2;
            color:white;
        }

        .hero-title {
            font-size: 50px;
            font-weight: bold;
        }

        .hero-sub {
            font-size: 18px;
        }

        .bg-f5f1e6 {
            background: #f5f1e6;
        }

        .bg-fff7f0 {
            background: #fff7f0;
        }

        .color-8b5e3c {
            color: #8b5e3c;
        }

    </style>
</head>
<body class="sidebar-collapse layout-fixed sidebar-expand-md">
    
<div class="app-wrapper">
    
    <!-- HEADER -->
    <header class="app-header navbar navbar-expand-md navbar-dark" style="background-color:#5c3d2e;">
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
                <ul class="navbar-nav d-md-flex d-none ms-auto">
                    <li class="nav-item"><a href="#" class="nav-link">Login</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Register</a></li>
                </ul>
            </div>
        </div>
    </header>

    <nav class="app-sidebar d-lg-none" style="background-color:#5c3d2e;">
        <ul class="navbar-nav p-3">
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
    </nav>

    <div class="app-main pb-0">
        
        <div class="bg-library ">
            <div class="content">
                <div class="container text-center pt-5 pb-3">
                    
                    <!-- HERO -->
                    <h1 class="hero-title">LibraGo</h1>
                    <p class="hero-sub">Smart Library Reservation and Borrowing Management System</p>
                    <p>Reserve books, select your borrow dates, and manage your library visits easily.</p>
                
                    <a href="#" class="btn btn-lg text-white m-5" style="background:#8b5e3c;">Get Started</a>
                
                    <!-- FEATURES -->

                    <h2 class="text-center mb-3 mt-3">User Features</h2>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card mb-2 shadow-lg">
                                <div class="card-body p-4">
                                    <h5><i class="bi bi-book me-2"></i>Book Reservation</h5>
                                    <p>Reserve available books based on your preferred dates.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-2 shadow-lg">
                                <div class="card-body p-4">
                                    <h5><i class="bi bi-clock me-2"></i>Flexible Borrowing</h5>
                                    <p>Select your borrow start date and return date based on availability.</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card mb-2 shadow-lg">
                                <div class="card-body p-4">
                                    <h5><i class="bi bi-calendar-check me-2"></i>Date Availability</h5>
                                    <p>See which dates are available before reserving a book.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- HOW IT WORKS -->
        <section class="content bg-light text-dark">
            <div class="container p-4">
                <h2 class="text-center mt-5 mb-3">How It Works</h2>
                
                <div class="row text-center">

                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-3 bg-fff7f0">
                            <div class="card-body">
                                <i class="bi bi-person-plus fs-1 color-8b5e3c"></i>
                                <h5>1. Register & Login</h5>
                                <p>Create your account and access the system.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-3 bg-fff7f0">
                            <div class="card-body">
                                <i class="bi bi-search fs-1 color-8b5e3c"></i>
                                <h5>2. Search Books</h5>
                                <p>Browse books and check their availability.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-3 bg-fff7f0">
                            <div class="card-body">
                                <i class="bi bi-calendar-event fs-1 color-8b5e3c"></i>
                                <h5>3. View Available Dates</h5>
                                <p>See which dates are available (unreserved dates are highlighted).</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-3 bg-fff7f0">
                            <div class="card-body">
                                <i class="bi bi-calendar-check fs-1 color-8b5e3c"></i>
                                <h5>4. Select Borrow Dates</h5>
                                <p>Select your preferred start and end dates. The system ensures your borrowing period does not exceed the maximum allowed duration.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-3 bg-fff7f0">
                            <div class="card-body">
                                <i class="bi bi-bookmark-check fs-1 color-8b5e3c"></i>
                                <h5>5. Confirm Reservation</h5>
                                <p>Reserve the book based on your selected schedule.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card shadow-sm p-3 mb-3 bg-fff7f0">
                            <div class="card-body">
                                <i class="bi bi-box-arrow-down fs-1 color-8b5e3c"></i>
                                <h5>6. Borrow & Return</h5>
                                <p>Pick up on your start date and return before the due date. Late returns will incur fines.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <p class="text-center mt-3 text-muted">
                    Note: Maximum borrowing duration is set by the library administrator.
                </p>
            </div>
        </section>

        <!-- FEEDBACKS -->
        <section class="content bg-f5f1e6 text-dark">
            <div class="container p-4">
                <h2 class="text-center mt-5 mb-3">User Feedback</h2>
                <div class="row text-center">
                    <div class="col-md-4">
                        <div class="card p-3">
                            <div class="card-body">
                                <p class="fst-italic">"LibraGo made borrowing books so easy! No more waiting in long lines."</p>
                                <p class="fw-bold">- Maria D.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3">
                            <div class="card-body">
                                <p class="fst-italic">"Scheduling my library visit online saved me so much time."</p>
                                <p class="fw-bold">- John P.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card p-3">
                            <div class="card-body">
                                <p class="fst-italic">"I love how easy it is to choose my borrow dates. So convenient!"</p>
                                <p class="fw-bold">- Aileen R.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="app-footer text-center text-white" style="background:#5c3d2e;">
        <strong>LibraGo</strong> - 2026
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/js/adminlte.min.js"></script>

</body>
</html>