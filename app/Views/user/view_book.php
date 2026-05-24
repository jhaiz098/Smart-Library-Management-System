<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | View Book
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    View Book
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="container-fluid p-3">

    <a href="/user/books" class="btn btn-secondary mb-3">
        ← Back
    </a>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="row g-3">

        <!-- LEFT -->
        <div class="col-lg-7">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <div class="d-flex justify-content-between align-items-start flex-wrap">

                        <div>
                            <div class="text-muted small mb-1">
                                <?= esc($book['category_name']) ?>
                            </div>

                            <h2 class="fw-bold mb-1">
                                <?= esc($book['title']) ?>
                            </h2>

                            <div class="text-secondary mb-3">
                                by <?= esc($book['author']) ?>
                            </div>
                        </div>

                        <div>

                            <?php if($book['availability'] === 'available'): ?>

                                <span class="badge bg-success px-3 py-2">
                                    Available
                                </span>

                            <?php else: ?>

                                <span class="badge bg-danger px-3 py-2">
                                    Borrowed
                                </span>

                            <?php endif; ?>

                        </div>

                    </div>

                    <hr>

                    <div class="row">

                        <div class="col-md-6 mb-3">

                            <div class="small text-muted">
                                Publisher
                            </div>

                            <div class="fw-semibold">
                                <?= esc($book['publisher']) ?>
                            </div>

                        </div>

                        <div class="col-md-6 mb-3">

                            <div class="small text-muted">
                                Published Year
                            </div>

                            <div class="fw-semibold">
                                <?= esc($book['published_year']) ?>
                            </div>

                        </div>

                    </div>

                    <div class="small text-muted mb-2">
                        Description
                    </div>

                    <div style="line-height: 1.8;">
                        <?= nl2br(esc($book['description'])) ?>
                    </div>

                </div>

            </div>

        </div>

        <!-- RIGHT -->
        <div class="col-lg-5">

            <!-- CURRENT BORROWER -->
            <div class="card border-0 shadow-sm mb-3">

                <div class="card-header bg-white fw-bold">
                    Current Borrowing
                </div>

                <div class="card-body">

                    <?php if($book['borrowings']): ?>

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="fw-semibold">

                                    <?= esc($book['borrowings']['borrower_full_name']) ?>

                                    <?php if($book['borrowings']['user_id'] == session()->get('user_id')): ?>

                                        <span class="badge bg-primary ms-1">
                                            You
                                        </span>

                                    <?php endif; ?>

                                </div>

                                <div class="text-muted small">
                                    <?= esc($book['borrowings']['borrower_library_id']) ?>
                                </div>

                            </div>

                            <span class="badge bg-danger">
                                Borrowed
                            </span>

                        </div>

                    <?php else: ?>

                        <div class="text-success fw-semibold">
                            This book is currently available.
                        </div>

                    <?php endif; ?>

                </div>

            </div>

            <!-- RESERVATION QUEUE -->
            <div class="card border-0 shadow-sm mb-3">

                <div class="card-header bg-white fw-bold">
                    Reservation Queue
                </div>

                <div class="card-body p-0">

                    <?php if(!empty($book['reservations'])): ?>

                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light">

                                <tr>
                                    <th width="10%">#</th>
                                    <th>User</th>
                                    <th width="25%">Status</th>
                                </tr>

                            </thead>

                            <tbody>

                                <?php $queue = 1; ?>

                                <?php foreach($book['reservations'] as $reservation): ?>

                                    <tr>

                                        <td class="fw-bold">
                                            <?= $queue ?>
                                        </td>

                                        <td>

                                            <div class="fw-semibold">

                                                <?= esc($reservation['reserver_full_name']) ?>

                                                <?php if($reservation['user_id'] == session()->get('user_id')): ?>

                                                    <span class="badge bg-primary ms-1">
                                                        You
                                                    </span>

                                                <?php endif; ?>

                                            </div>

                                            <div class="small text-muted">
                                                <?= esc($reservation['reserver_library_id']) ?>
                                            </div>

                                        </td>

                                        <td>

                                            <?php if($queue == 1): ?>

                                                <span class="badge bg-success">
                                                    Next
                                                </span>

                                            <?php else: ?>

                                                <span class="badge bg-secondary">
                                                    Waiting
                                                </span>

                                            <?php endif; ?>

                                        </td>

                                    </tr>

                                    <?php $queue++; ?>

                                <?php endforeach; ?>

                            </tbody>

                        </table>

                    <?php else: ?>

                        <div class="p-3 text-muted">
                            No reservations yet.
                        </div>

                    <?php endif; ?>

                </div>

            </div>

            <!-- USER ACTIVITY -->
            <?php if($book['has_active_borrow_request'] || $book['user_reservation']): ?>

                <div class="card border-0 shadow-sm mb-3">

                    <div class="card-header bg-white fw-bold">
                        Your Activity
                    </div>

                    <div class="card-body">

                        <?php if($book['user_reservation']): ?>

                            <?php
                                $position = 0;
                                $counter = 1;

                                foreach($book['reservations'] as $r) {

                                    if($r['user_id'] == session()->get('user_id')) {
                                        $position = $counter;
                                        break;
                                    }

                                    $counter++;
                                }
                            ?>

                            <div class="border rounded p-3 mb-3">

                                <div class="fw-bold text-secondary mb-2">
                                    Your Reservation
                                </div>

                                <div class="mb-2">

                                    <span class="badge bg-info text-dark">
                                        Queue Position #<?= $position ?>
                                    </span>

                                </div>

                                <?php if($book['is_first_reserver']): ?>

                                    <?php if(
                                        $book['user_borrow_request'] &&
                                        in_array($book['user_borrow_request']['status'], [
                                            'pending',
                                            'approved',
                                            'rejected'
                                        ])
                                    ): ?>

                                        <div class="text-primary fw-semibold">
                                            ⏳ You already sent a borrow request. Waiting for approval.
                                        </div>

                                        <div class="small text-muted mt-1">
                                            Your reservation is being processed.
                                        </div>

                                    <?php else: ?>

                                        <div class="text-success fw-semibold">
                                            🎉 It’s your turn in the queue.
                                        </div>

                                        <div class="small text-muted">
                                            You can now send a borrow request.
                                        </div>

                                    <?php endif; ?>

                                <?php else: ?>

                                    <div class="small text-muted">
                                        Waiting for your turn in the reservation queue.
                                    </div>

                                <?php endif; ?>

                            </div>

                        <?php endif; ?>
                        
                        <?php if(
                            $book['user_borrow_request'] &&
                            in_array($book['user_borrow_request']['status'], [
                                'pending',
                                'approved',
                                'rejected'
                            ])
                        ): ?>

                            <div class="border rounded p-3">

                                <div class="fw-bold text-primary mb-2">
                                    Borrow Request
                                </div>

                                <div class="small text-muted mb-1">
                                    Status
                                </div>

                                <?php if($book['user_borrow_request']['status'] == 'pending'): ?>

                                    <span class="badge bg-warning text-dark mb-2">
                                        Pending
                                    </span>

                                    <div class="small text-muted">
                                        Your borrow request is waiting for librarian approval.
                                    </div>

                                <?php elseif($book['user_borrow_request']['status'] == 'approved'): ?>

                                    <span class="badge bg-success mb-2">
                                        Approved
                                    </span>

                                    <div class="alert alert-success mt-2 mb-0">

                                        <div class="fw-semibold mb-2">
                                            Your request has been approved.
                                        </div>

                                        <div class="small mb-1">
                                            Claim Code
                                        </div>

                                        <div class="fw-bold fs-5 text-dark">
                                            <?= esc($book['user_borrow_request']['claim_code']) ?>
                                        </div>

                                        <hr>

                                        <div class="small text-muted">
                                            Please present this claim code to the librarian when claiming the book.
                                        </div>

                                    </div>

                                <?php elseif($book['user_borrow_request']['status'] == 'rejected'): ?>

                                    <span class="badge bg-danger mb-2">
                                        Rejected
                                    </span>

                                    <div class="small text-muted">
                                        Your borrow request was rejected by the librarian.
                                    </div>

                                <?php endif; ?>

                            </div>

                        <?php endif; ?>
                    </div>

                </div>

            <?php endif; ?>

            <!-- ACTIONS -->
            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white fw-bold">
                    Actions
                </div>

                <div class="card-body">

                    <?php foreach ($buttons as $btn): ?>

                        <?php if($btn['action'] === '#'): ?>

                            <button
                                type="button"
                                class="btn btn-<?= $btn['color'] ?> w-100 mb-2"
                                disabled>

                                <?= $btn['text'] ?>

                            </button>

                        <?php else: ?>
                            <?php
                                $confirmMessage = 'Are you sure you want to proceed?';

                                if (
                                    str_contains($btn['action'], 'cancel_borrow_request')
                                ) {
                                    $confirmMessage = 'Cancelling this borrow request will also remove your reservation from the queue. Continue?';
                                }
                            ?>
                            <form action="<?= $btn['action'] ?>"
                                method="post"
                                class="mb-2"
                                onsubmit="return confirm('<?= $confirmMessage ?>')">

                                <input type="hidden"
                                    name="user_id"
                                    value="<?= session()->get('user_id') ?>">

                                <input type="hidden"
                                    name="book_id"
                                    value="<?= $book['id'] ?>">

                                <input type="submit"
                                    value="<?= $btn['text'] ?>"
                                    class="btn btn-<?= $btn['color'] ?> w-100">

                            </form>

                        <?php endif; ?>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection(); ?>