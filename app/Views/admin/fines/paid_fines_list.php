<?= $this->extend('layouts/fines_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Paid Fines
<?= $this->endSection() ?>
