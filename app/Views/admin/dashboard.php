<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | Dashboard
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Dashboard
<?= $this->endSection() ?>