<div class="mb-4">

    <ul class="nav nav-pills gap-2">

        <li class="nav-item">

            <a href="<?= site_url('admin/library_settings') ?>"
               class="nav-link <?= ($settings_type == 'library_settings') ? 'active' : 'text-dark' ?>">

                <i class="bi bi-gear-fill me-1"></i>
                Library Settings

            </a>

        </li>

        <li class="nav-item">

            <a href="<?= site_url('admin/category_management_settings') ?>"
               class="nav-link <?= ($settings_type == 'category_management_settings') ? 'active' : 'text-dark' ?>">

                <i class="bi bi-tags-fill me-1"></i>
                Category Management

            </a>

        </li>

        <li class="nav-item">

            <a href="<?= site_url('admin/role_permissions_settings') ?>"
               class="nav-link <?= ($settings_type == 'role_permissions_settings') ? 'active' : 'text-dark' ?>">

                <i class="bi bi-shield-lock-fill me-1"></i>
                Role & Permissions

            </a>

        </li>

    </ul>

</div>