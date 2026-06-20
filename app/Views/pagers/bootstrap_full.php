<?php $pager->setSurroundCount(2) ?>

<nav aria-label="Page navigation" class="mt-3">
    <ul class="pagination justify-content-center flex-wrap gap-1">

        <!-- FIRST + PREV -->
        <?php if ($pager->hasPrevious()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getFirst() ?>">
                    « First
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="<?= $pager->getPrevious() ?>">
                    ‹ Prev
                </a>
            </li>
        <?php endif ?>

        <!-- PAGE NUMBERS -->
        <?php foreach ($pager->links() as $link): ?>
            <li class="page-item <?= $link['active'] ? 'active' : '' ?>">
                <a class="page-link" href="<?= $link['uri'] ?>">
                    <?= $link['title'] ?>
                </a>
            </li>
        <?php endforeach ?>

        <!-- NEXT + LAST -->
        <?php if ($pager->hasNext()) : ?>
            <li class="page-item">
                <a class="page-link" href="<?= $pager->getNext() ?>">
                    Next ›
                </a>
            </li>

            <li class="page-item">
                <a class="page-link" href="<?= $pager->getLast() ?>">
                    Last »
                </a>
            </li>
        <?php endif ?>

    </ul>
</nav>