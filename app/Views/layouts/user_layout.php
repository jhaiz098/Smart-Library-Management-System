<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>

    <!-- BOOTSTRAP -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- ADMIN LTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/css/adminlte.min.css">

    <!-- BOOTSTRAP ICONS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">

    <!-- FULLCALENDAR -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/js/adminlte.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <!-- UI CLEAN DESIGN (NO HOVER DISTRACTION) -->
    <style>

        /* BACKGROUND */
        body.bg-light-yellow {
            background: #f7f5ef;
        }

        /* PAGE HEADER */
        .page-header {
            background: #ffffff;
            box-shadow: 0 4px 12px rgba(0,0,0,0.05);
            font-weight: 600;
            font-size: 16px;
        }

        /* CARDS (CLEAN + STATIC) */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.05) !important;
            transition: none !important; /* REMOVE HOVER ANIMATION */
        }

        /* REMOVE ANY HOVER EFFECTS */
        .card:hover {
            transform: none !important;
            box-shadow: 0 4px 14px rgba(0,0,0,0.05) !important;
        }

        /* HEADER */
        .card-header {
            background: #fff !important;
            border-bottom: 1px solid rgba(0,0,0,0.06);
            font-weight: 600;
        }

        /* TABLE CLEAN LOOK */
        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: #f8f9fa;
        }

    </style>

</head>

<body class="bg-light-yellow">

    <div class="app-wrapper">

        <!-- USER HEADER -->
        <?= $this->include('partials/user/header') ?>
        <?= $this->include('partials/user/navbar') ?>

        <!-- PAGE HEADER -->
        <div class="page-header m-3 p-3 rounded">
            <?= $this->renderSection('header') ?>
        </div>

        <!-- MAIN -->
        <main>
            <?= $this->renderSection('content') ?>
        </main>

        <!-- FOOTER -->
        <?= $this->include('partials/user/footer') ?>

    </div>

</body>

</html>