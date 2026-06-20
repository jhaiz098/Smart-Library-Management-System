<?= $this->extend('layouts/admin_layout') ?>

<?= $this->section('title') ?>
    <?= session()->get('role_id') == 1 ? 'Admin' : 'Staff' ?> | View Book
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    View Book
<?= $this->endSection() ?>

<?= $this->section('content') ?>
    <div class="p-3">
        <a href="/admin/book_management" class="btn btn-secondary">Back</a>
        
        <div class="row">
            <div class="col-lg-7">
                <div class="card mt-3">
                    <div class="card-header fw-bold">Book Information</div>
                    <div class="card-body">
                        <p>
                            <b>Category: </b> <?= $book['category_name'] ?>
                        </p>
                        <p>
                            <b>Title: </b> <?= $book['title'] ?>
                        </p>
                        <p>
                            <b>Author: </b> <?= $book['author'] ?>
                        </p>
                        <p>
                            <b>Description: </b> <?= $book['description'] ?>
                        </p>
                        <p>
                            <b>Published Year: </b> <?= $book['published_year'] ?>
                        </p>
                        <p>
                            <b>Publisher: </b> <?= $book['publisher'] ?>
                        </p>
                        <p>
                            <b>Status: </b> <?= $book['status'] ?>
                        </p>
                        <p>
                            <b>Created at: </b> <?= $book['created_at'] ?>
                        </p>
                        <p>
                            <b>Updated at: </b> <?= $book['updated_at'] ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card mt-3">
                    <div class="card-header fw-bold">Book Calendar</div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 500,

        events: <?= json_encode($events ?? []) ?>

    });

    calendar.render();
});
</script>
<?= $this->endSection() ?>