<?php

namespace RebelCode\WordPress\Admin\Menu;

interface BuiltInMenu
{
    const DASHBOARD        = 'index.php';
    const POSTS            = 'edit.php';
    const MEDIA            = 'upload.php';
    const PAGES            = 'edit.php?post_type=page';
    const COMMENTS         = 'edit-comments.php';
    const APPEARANCE       = 'themes.php';
    const PLUGINS          = 'plugins.php';
    const USERS            = 'users.php';
    const TOOLS            = 'tools.php';
    const SETTINGS         = 'options-general.php';
    const NETWORK_SETTINGS = 'settings.php';
}
