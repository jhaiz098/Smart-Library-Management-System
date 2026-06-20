<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | View Book
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    View Book
<?= $this->endSection() ?>


<?= $this->section('content') ?>
    <div class="p-3">
        <a href="/user/books" class="btn btn-secondary">Back</a>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>
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
                    </div>
                </div>
            </div>

            <div class="col-lg-5">
                <div class="card mt-3">
                    <div class="card-header fw-bold">Borrowing & Reservations</div>
                    <div class="card-body">
                        <table class="table table-bordered table-responsive fs-7">
                            <tr>
                                <th>No.</th>
                                <th>Library ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Status</th>
                            </tr>
                            <?php $no = 1; ?>
                            <?php if($book['borrowings']):?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?= $book['borrowing']['user_id'] ?? '-' ?></td>
                                <td>Default Name</td>
                                <td>Borrow</td>
                                <td><?= $book['borrowing']['status'] ?? 'Available' ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php if($book['user_borrow_request']): ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?= $book['user_borrow_request']['user_id'] ?></td>
                                <td>Default Name</td>
                                <td>Borrow Request</td>
                                <td><?= $book['user_borrow_request']['status'] ?></td>
                            </tr>
                            <?php endif; ?>

                            <?php foreach($book['reservations'] as $reservation): ?>
                            <tr>
                                <td><?php echo $no; ?></td>
                                <td><?= $reservation['user_id'] ?></td>
                                <td>Default Name</td>
                                <td>Reservation</td>
                                <td><?= $reservation['status'] ?></td>
                            </tr>
                            <?php endforeach; ?>

                            <?php $no++; ?>

                        </table>
                    </div>
                </div>
            </div>

        </div>
        
        <div class="row mt-3">
            <div class="col-lg-3">
                
                <?php foreach ($buttons as $btn): ?>
                    <form action="<?= $btn['action'] ?>" method="post"
                        onsubmit="return confirm('Are you sure you want to proceed?')">

                        <input type="hidden" name="user_id" value="<?= session()->get('user_id') ?>">
                        <input type="hidden" name="book_id" value="<?= $book['id'] ?>">

                        <input type="submit" value="<?= $btn['text'] ?>"
                            class="btn btn-<?= $btn['color'] ?>">
                    </form>
                <?php endforeach; ?>

            </div>
        </div>
    </div>
<?= $this->endSection(); ?>