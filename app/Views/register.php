<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - LibraGo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="css/style.css">
    
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

<div class="app-main p-4 bg-light-yellow">

    <a href="/" class="btn bg-dark-brown text-white position-absolute">Home</a>

    <div class="container mh-100vh d-flex align-items-center justify-content-center">
        
        <div class="col-md-5">
            <div class="card register-card shadow-lg p-4">

                <!-- Brand -->
                <div class="text-center mb-3">
                    <h3 class="fw-bold text-dark-dark-brown">
                        <i class="bi bi-book me-2"></i> LibraGo
                    </h3>
                    <p class="text-muted">Create your account</p>
                </div>

                <!-- FORM -->
                <form method="POST" action="/register">
                    <small class="text-muted">
                        Note: Fields marked with <span class="text-danger">*</span> are required.
                    </small>

                    <div class="mb-3 mt-2">
                        <label class="form-label">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" class="form-control" placeholder="Enter your full name" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Contact Number <small class="text-muted">(Optional)</small></label>
                        <input type="text" name="contact_number" class="form-control" placeholder="Enter your contact number">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" name="password" class="form-control" placeholder="Create password" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Confirm Password <span class="text-danger">*</span></label>
                        <input type="password" name="confirm_password" class="form-control" placeholder="Confirm password" required>
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-main">
                            Register
                        </button>
                    </div>

                    <div class="text-center">
                        <small>
                            Already have an account?
                            <a href="/login" class="text-decoration-none text-dark-brown">
                                Login
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