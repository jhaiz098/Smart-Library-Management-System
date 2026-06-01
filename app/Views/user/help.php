```php
<?= $this->extend('layouts/user_layout') ?>

<?= $this->section('title') ?>
    User | Help
<?= $this->endSection() ?>

<?= $this->section('header') ?>
    Help & Library Policies
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<div class="px-3 py-0">

    <!-- PAGE INTRO -->
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white">

            <div>
                <div class="fw-bold">
                    Help Center
                </div>

                <div class="text-muted small">
                    Important guidelines, policies, and answers to common questions.
                </div>
            </div>

        </div>

        <div class="card-body">

            <p class="text-muted mb-0">
                Review the library policies below to understand borrowing rules,
                reservations, fines, and request procedures. Following these
                guidelines helps ensure fair access to library resources for everyone.
            </p>

        </div>

    </div>

    <div class="row g-4">

        <!-- BORROWING RULES -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <div class="fw-semibold">
                        <i class="bi bi-book me-2 text-primary"></i>
                        Borrowing Rules
                    </div>

                    <div class="text-muted small">
                        Requirements and responsibilities when borrowing books.
                    </div>

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
                            Maximum fine per borrowing:
                            <strong>
                                ₱<?= number_format($library_settings['max_fine_amount'], 2) ?>
                            </strong>.
                        </li>

                        <li>
                            Borrowing privileges may be restricted when unpaid fines exist.
                        </li>

                        <li>
                            Approved borrow requests must be claimed before expiration.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- RESERVATIONS -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <div class="fw-semibold">
                        <i class="bi bi-bookmark-check me-2 text-primary"></i>
                        Reservations
                    </div>

                    <div class="text-muted small">
                        Information about reservation queues and availability.
                    </div>

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
                            Users must wait for their queue position before submitting a borrow request.
                        </li>

                        <li>
                            Cancelling a reservation removes your queue position.
                        </li>

                        <li>
                            Reservations do not guarantee automatic borrowing approval.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

        <!-- FINES -->
        <div class="col-lg-6">

            <div class="card border-0 shadow-sm h-100">

                <div class="card-header bg-white">

                    <div class="fw-semibold">
                        <i class="bi bi-cash-coin me-2 text-primary"></i>
                        Fines & Penalties
                    </div>

                    <div class="text-muted small">
                        Information regarding overdue charges and restrictions.
                    </div>

                </div>

                <div class="card-body">

                    <ul class="mb-0">

                        <li>
                            Fines are automatically calculated for late returns.
                        </li>

                        <li>
                            The fine amount depends on the number of overdue days.
                        </li>

                        <li>
                            No additional charges are added once the maximum fine is reached.
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

                <div class="card-header bg-white">

                    <div class="fw-semibold">
                        <i class="bi bi-clipboard-check me-2 text-primary"></i>
                        Borrow Requests
                    </div>

                    <div class="text-muted small">
                        How book requests and claim codes work.
                    </div>

                </div>

                <div class="card-body">

                    <ul class="mb-0">

                        <li>
                            Available books require a borrow request before claiming.
                        </li>

                        <li>
                            Requests are reviewed and approved by the librarian.
                        </li>

                        <li>
                            Approved requests generate a claim code.
                        </li>

                        <li>
                            Claim codes must be presented when claiming books.
                        </li>

                        <li>
                            Unclaimed requests may expire and be cancelled.
                        </li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <!-- FAQ -->
    <div class="card border-0 shadow-sm mt-4">

        <div class="card-header bg-white">

            <div>
                <div class="fw-bold">
                    <i class="bi bi-question-circle me-2 text-primary"></i>
                    Frequently Asked Questions
                </div>

                <div class="text-muted small">
                    Quick answers to common library questions.
                </div>
            </div>

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
```
