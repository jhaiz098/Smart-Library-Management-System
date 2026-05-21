
<ul class="nav nav-tabs">
    <li class="nav-item">
        <a href="library_settings" class="nav-link <?= ($settings_type) == "library_settings" ? 'active' : '' ?>">Library Setting</a>
    </li>
    <li class="nav-item">
        <a href="category_management_settings" class="nav-link <?= ($settings_type) == "category_management_settings" ? 'active' : '' ?>">Category Management</a>
    </li>
    <li class="nav-item">
        <a href="role_permissions_settings" class="nav-link <?= ($settings_type) == "role_permissions_settings" ? 'active' : '' ?>">Role & Permissions</a>
    </li>
</ul>