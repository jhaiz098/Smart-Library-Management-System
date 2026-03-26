<!DOCTYPE html>
<html>
<head>
    <title>QueueLib</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <style>
        .bg-library {
            position: relative;
            min-height: 100vh;
            background: url('https://images.unsplash.com/photo-1521587760476-6c12a4b040da') no-repeat center center/cover;
        }

        .bg-library::before {
            content: "";
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(60, 40, 20, 0.75);
            top: 0;
            left: 0;
        }

        .content {
            position: relative;
            z-index: 2;
            color: white;
        }

        .hero-title {
            font-size: 50px;
            font-weight: bold;
        }

        .hero-sub {
            font-size: 18px;
        }

        .card {
            background: rgba(255,255,255,0.9);
            border-radius: 12px;
        }

        /* Features */
        .feature-card {
            background: rgba(255,255,255,0.95);
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 30px;
            transition: transform 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }


        /* Feedback */
        .feedback-section {
            background: #f5f1e6;
            padding: 60px 0;
        }

        .feedback-card {
            background: white;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .feedback-text {
            font-style: italic;
            margin-bottom: 10px;
        }

        .feedback-name {
            font-weight: bold;
            text-align: right;
        }

        
        /* How it works */
        .steps-section {
            padding: 60px 0;
        }

        .step-card {
            background: #fff7f0;
            border-radius: 12px;
            padding: 30px;
            text-align: center;
            margin-bottom: 30px;
        }

        .step-icon {
            font-size: 40px;
            color: #8b5e3c;
            margin-bottom: 15px;
        }
    </style>
</head>

<body class="layout-top-nav">

<div class="app-wrapper">

    <!-- NAVBAR -->
    <nav class="app-header px-5 py-3 navbar navbar-expand-md navbar-dark" style="background-color:#5c3d2e;">
        <a href="#" class="nav-brand">
            <span class="fw-bold">
                <i class="bi bi-book me-2"></i> QueueLib
            </span>
        </a>

        <ul class="navbar-nav ms-auto">
            <li class="nav-item"><a href="#features" class="nav-link">Features</a></li>
            <li class="nav-item"><a href="#how-it-works" class="nav-link">How It Works</a></li>
            <li class="nav-item"><a href="#feedback" class="nav-link">Feedback</a></li>
            <li class="nav-item"><a href="/login" class="nav-link">Login</a></li>
            <li class="nav-item"><a href="/register" class="nav-link">Register</a></li>
        </ul>
    </nav>

    <!-- MAIN -->
    <div class="app-main">
        <div class="bg-library">
            <div class="content">
                <div class="container text-center pt-5">

                    <!-- HERO -->
                    <h1 class="hero-title">QueueLib</h1>
                    <p class="hero-sub">
                        Smart Library Reservation and Queue Management System
                    </p>
                    <p>
                        Reserve books, schedule visits, and skip long waiting lines.
                    </p>
                    <a href="/login" class="btn btn-lg text-white mt-3" style="background:#8b5e3c;">
                        Get Started
                    </a>

                    <!-- FEATURES -->
                    <section id="features" class="container py-5">
                        <h2 class="text-center mb-5">Features for Users</h2>
                        <div class="row text-dark">
                            <div class="col-md-4">
                                <div class="feature-card shadow-sm">
                                    <h5><i class="bi bi-book me-2"></i>Book Reservation</h5>
                                    <p>Reserve books online anytime, without waiting in line.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card shadow-sm">
                                    <h5><i class="bi bi-clock me-2"></i>Scheduling</h5>
                                    <p>Choose your preferred time to visit the library.</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="feature-card shadow-sm">
                                    <h5><i class="bi bi-ticket-perforated me-2"></i>Queue System</h5>
                                    <p>Track your queue position and reduce waiting time.</p>
                                </div>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>

        <!-- HOW IT WORKS -->
        <section id="how-it-works" class="steps-section bg-light text-dark">
            <div class="container">
                <h2 class="text-center mb-5">How It Works</h2>
                <div class="row">
                    <div class="col-md-4">
                        <div class="step-card shadow-sm">
                            <div class="step-icon"><i class="bi bi-search"></i></div>
                            <h5>Search Books</h5>
                            <p>Look for books and check availability online.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card shadow-sm">
                            <div class="step-icon"><i class="bi bi-calendar-check"></i></div>
                            <h5>Reserve & Schedule</h5>
                            <p>Reserve your book and choose your visit time.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="step-card shadow-sm">
                            <div class="step-icon"><i class="bi bi-people"></i></div>
                            <h5>Queue & Collect</h5>
                            <p>Track your queue in real-time and collect your book hassle-free.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- FEEDBACKS -->
        <section id="feedback" class="feedback-section">
            <div class="container">
                <h2 class="text-center mb-5">User Feedback</h2>
                <div class="row justify-content-center">
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <p class="feedback-text">"QueueLib made borrowing books so easy! No more waiting in long lines."</p>
                            <p class="feedback-name">- Maria D.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <p class="feedback-text">"Scheduling my library visit online saved me so much time."</p>
                            <p class="feedback-name">- John P.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="feedback-card">
                            <p class="feedback-text">"I love seeing my queue status in real-time. So convenient!"</p>
                            <p class="feedback-name">- Aileen R.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- FOOTER -->
    <footer class="app-footer text-center mt-4 py-3" style="background:#5c3d2e; color:white;">
        <strong>QueueLib</strong> - 2026
    </footer>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/js/adminlte.min.js"></script>

</body>
</html>