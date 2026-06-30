<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Help
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Help & Library Policies
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="p-3">

    <!-- QUICK OVERVIEW -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <h4 class="fw-bold mb-2">
                Library Guidelines
            </h4>

            <p class="text-muted mb-0">
                This page contains important information about borrowing books,
                reservation procedures, overdue fines, and frequently asked
                questions. Please review these guidelines before using the
                library services.
            </p>

        </div>

    </div>

    <div class="row g-3">

        <!-- BORROWING RULES -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white fw-bold">
                    Borrowing Rules
                </div>

                <div class="card-body">

                    <ul class="mb-0">

                        <li>
                            Books must be returned on or before the due date.
                        </li>

                        <li>
                            Overdue books incur a fine of
                            <strong>
                                ₱<?= number_format($library_settings['daily_overdue_fine'], 2) ?>
                            </strong>
                            per day.
                        </li>

                        <li>
                            The maximum fine per borrowing is
                            <strong>
                                ₱<?= number_format($library_settings['max_fine_amount'], 2) ?>
                            </strong>.
                        </li>

                        <li>
                            Borrowing privileges may be restricted when unpaid fines exist.
                        </li>

                        <li>
                            Approved borrow requests must be claimed before they expire.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- RESERVATIONS -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white fw-bold">
                    Reservations
                </div>

                <div class="card-body">

                    <ul class="mb-0">

                        <li>
                            Borrowed books may be reserved.
                        </li>

                        <li>
                            Reservations are processed on a first-come, first-served basis.
                        </li>

                        <li>
                            Users must wait for their turn in the reservation queue before sending a borrow request.
                        </li>

                        <li>
                            Cancelling a reservation removes your position in the queue.
                        </li>

                        <li>
                            Reserved books do not guarantee automatic borrowing approval.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- FINES -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white fw-bold">
                    Fines & Penalties
                </div>

                <div class="card-body">

                    <ul class="mb-0">

                        <li>
                            Fines are automatically calculated when a book is returned late.
                        </li>

                        <li>
                            The fine amount depends on the number of overdue days.
                        </li>

                        <li>
                            Once the maximum fine amount is reached, no additional charges are added.
                        </li>

                        <li>
                            Outstanding fines must be settled with the librarian.
                        </li>

                        <li>
                            Users with unresolved fines may have borrowing restrictions.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- BORROW REQUESTS -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white fw-bold">
                    Borrow Requests
                </div>

                <div class="card-body">

                    <ul class="mb-0">

                        <li>
                            Available books require a borrow request before claiming.
                        </li>

                        <li>
                            Borrow requests are reviewed by the librarian.
                        </li>

                        <li>
                            Approved requests generate a claim code.
                        </li>

                        <li>
                            Claim codes must be presented when claiming books.
                        </li>

                        <li>
                            Unclaimed approved requests may be cancelled after expiration.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- FAQ -->
    <div class="card border-0 shadow-sm mt-4">

        <div class="card-header bg-white fw-bold">
            Frequently Asked Questions
        </div>

        <div class="card-body">

            <div class="accordion" id="faqAccordion">

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button class="accordion-button"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faq1">

                            How do I borrow a book?

                        </button>

                    </h2>

                    <div id="faq1"
                        class="accordion-collapse collapse show"
                        data-bs-parent="#faqAccordion">

                        <div class="accordion-body">

                            Open the book page, submit a borrow request, and wait for librarian approval.

                        </div>

                    </div>

                </div>

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faq2">

                            How do reservations work?

                        </button>

                    </h2>

                    <div id="faq2"
                        class="accordion-collapse collapse"
                        data-bs-parent="#faqAccordion">

                        <div class="accordion-body">

                            If a book is currently borrowed, you may join the reservation queue and wait for your turn.

                        </div>

                    </div>

                </div>

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faq3">

                            What happens if I return a book late?

                        </button>

                    </h2>

                    <div id="faq3"
                        class="accordion-collapse collapse"
                        data-bs-parent="#faqAccordion">

                        <div class="accordion-body">

                            An overdue fine will be applied based on the number of overdue days, up to the maximum fine amount.

                        </div>

                    </div>

                </div>

                <div class="accordion-item">

                    <h2 class="accordion-header">

                        <button class="accordion-button collapsed"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#faq4">

                            Where can I view my transactions and fines?

                        </button>

                    </h2>

                    <div id="faq4"
                        class="accordion-collapse collapse"
                        data-bs-parent="#faqAccordion">

                        <div class="accordion-body">

                            You can view them through the My Transactions, Overdue, and Fines pages in the navigation menu.

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<?= $this->endSection() ?>