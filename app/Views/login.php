<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - LibraGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <style>
        .btn-main {
            background: #8b5e3c;
            color: white;
        }

        .btn-main:hover {
            background: #6f472d;
            color: white;
        }
    </style>
</head>
<body>

<div class="app-wrapper">

<div class="app-main bg-light-yellow">

    <a href="/" class="btn ms-4 mt-4 bg-dark-brown text-white position-absolute">Home</a>

    <div class="container mh-100vh d-flex align-items-center justify-content-center">
        
        <div class="col-md-4">
            <div class="card shadow-lg p-4">

                <!-- Brand -->
                <div class="text-center mb-3">
                    <h3 class="fw-bold text-dark-dark-brown">
                        <i class="bi bi-book me-2"></i> LibraGo
                    </h3>
                    <p class="text-muted">Login to your account</p>
                </div>

                <?php if(session()->getFlashdata('success')): ?>
                    <div class="alert alert-success border-0 shadow-sm">
                        <?= session()->getFlashdata('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->getFlashdata('error')): ?>
                    <div class="alert alert-danger">
                        <?= session()->getFlashdata('error') ?>
                    </div>
                <?php endif; ?>

                <!-- FORM -->
                <form method="post" action="/login/auth">

                    <div class="mb-3">
                        <label class="form-label">Email or Library Card ID</label>
                        <input type="text" name="login" class="form-control" placeholder="Enter your email or library ID" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-main">
                            Login
                        </button>
                    </div>

                    <div class="text-center">
                        <small>
                            Don't have an account? 
                            <a href="/register" class="text-decoration-none text-dark-brown">
                                Register
                            </a>
                        </small>
                    </div>

                </form>

            </div>
        </div>

    </div>

</div>

</div>

</body>
</html>