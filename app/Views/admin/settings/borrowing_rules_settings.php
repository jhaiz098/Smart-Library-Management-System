<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Setting
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Settings
<?= $this->endSection() ?>

<?= $this->section('content') ?>


    <div class="p-3">
        <div class="card">
            <div class="card-header fw-bold">Settings</div>
            <div class="card-body">
                <?= view('partials/admin/settings_nav') ?>


            </div>
        </div>
    </div>


<?= $this->endSection() ?>