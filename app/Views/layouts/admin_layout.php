<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $this->renderSection('title') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
    <?= $this->renderSection('head') ?>
</head>
<body class="bg-light-yellow sidebar-collapse sidebar-expand-lg">
    <div class="app-wrapper">
        <?= $this->include('partials/admin/navbar') ?>

        <main>
            <div class="card rounded-0 d-flex flex-row align-items-center">
                <a href="#" class="btn btn-link text-black ms-2 fs-5" data-lte-toggle="sidebar"><i class="bi bi-list"></i></a>
                <div class="card-header fw-bold">
                    <?= $this->renderSection('header') ?>
                </div>
            </div>

            <?= $this->renderSection('content') ?>
        </main>

        <?= $this->include('partials/admin/footer') ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-rc3/dist/js/adminlte.min.js"></script>
</body>
</html>