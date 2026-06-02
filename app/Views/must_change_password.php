<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Change Password</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #f5efe6, #e6d5c3);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        .card {
            border: none;
            border-radius: 14px;
            background: #fffaf5;
            box-shadow: 0 10px 25px rgba(90, 60, 30, 0.15);
        }

        .brand-icon {
            font-size: 42px;
            color: #8b5e3c;
        }

        h4 {
            color: #5c3b1e;
        }

        .text-muted {
            color: #8a6f5a !important;
        }

        .form-label {
            color: #5c3b1e;
            font-weight: 600;
        }

        .form-control {
            border-radius: 8px;
            border: 1px solid #d6c3b1;
        }

        .form-control:focus {
            border-color: #8b5e3c;
            box-shadow: 0 0 0 0.2rem rgba(139, 94, 60, 0.2);
        }

        .btn-brown {
            background-color: #8b5e3c;
            color: #fff;
            border-radius: 8px;
        }

        .btn-brown:hover {
            background-color: #6e452c;
            color: #fff;
        }

        .alert-danger {
            background: #f8e6e0;
            border: 1px solid #e0b8a8;
            color: #6b3b2e;
        }

        .alert-success {
            background: #e8f3ea;
            border: 1px solid #b8d6bf;
            color: #2f5d3a;
        }
    </style>
</head>

<body>

<div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">

    <div class="col-md-5">

        <div class="card p-4">

            <div class="text-center mb-4">

                <div class="brand-icon mb-2">
                    <i class="bi bi-shield-lock-fill"></i>
                </div>

                <h4 class="fw-bold">Change Your Password</h4>

                <p class="text-muted small">
                    You must update your temporary password before continuing
                </p>

            </div>

            <!-- ERROR -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger">
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <!-- SUCCESS -->
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <?= session()->getFlashdata('success') ?>
                </div>
            <?php endif; ?>

            <form action="/auth/update_password" method="post">

                <?= csrf_field() ?>

                <!-- CURRENT PASSWORD -->
                <div class="mb-3">

                    <label class="form-label">Current Password</label>

                    <input type="password"
                           name="current_password"
                           class="form-control"
                           placeholder="Enter temporary password"
                           required>

                </div>

                <!-- NEW PASSWORD -->
                <div class="mb-3">

                    <label class="form-label">New Password</label>

                    <input type="password"
                           name="new_password"
                           class="form-control"
                           placeholder="Enter new password"
                           required>

                </div>

                <!-- CONFIRM PASSWORD -->
                <div class="mb-3">

                    <label class="form-label">Confirm Password</label>

                    <input type="password"
                           name="confirm_password"
                           class="form-control"
                           placeholder="Confirm new password"
                           required>

                </div>

                <!-- BUTTON -->
                <button type="submit" class="btn btn-brown w-100">
                    Update Password
                </button>

            </form>

        </div>

        <p class="text-center text-muted small mt-3">
            Library Management System
        </p>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>