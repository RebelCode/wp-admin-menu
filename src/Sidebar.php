<?php

namespace RebelCode\WordPress\Admin\Menu;

use RebelCode\WordPress\Admin\Page\PageAwareInterface;

/**
 * Wrapper for WordPress' admin menu sidebar.
 *
 * @since [*next-version*]
 */
class Sidebar extends AbstractMenuBar implements RegisterMenuCapableInterface
{
    /**
     * The default menu icon URL.
     *
     * @since [*next-version*]
     */
    const DEFAULT_ICON_URL = 'dashicons-admin-generic';

    /**
     * The default icon HTML class.
     *
     * @since [*next-version*]
     */
    const DEFAULT_ICON_CLASS = 'menu-icon-generic';

    /**
     * The name of the method to invoke when a menu is selected.
     *
     * @since [*next-version*]
     */
    const MENU_ON_SELECTED_METHOD = 'onSelected';

    /**
     * The key of the label in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_LABEL = 0;

    /**
     * The key of the capability in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_CAPABILITY = 1;

    /**
     * The key of the slug in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_SLUG = 2;

    /**
     * The key of the page title in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_PAGE_TITLE = 3;

    /**
     * The key of the HTML class in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_HTML_CLASS = 4;

    /**
     * The key of the hook name in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_HOOK_NAME = 5;

    /**
     * The key of the icon URL in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_ICON_URL = 6;

    /**
     * The WordPress $menu global.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $wpMenu;

    /**
     * The WordPress $submenu global.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $wpSubmenu;

    /**
     * The WordPress $_wp_submenu_nopriv global.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $wpSubmenuNoPriv;

    /**
     * The WordPress $_wp_real_parent_file global.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $wpRealParentFile;

    /**
     * The WordPress $_registered_pages global.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $wpRegisteredPages;

    /**
     * The WordPress $_parent_pages global.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $wpParentPages;

    /**
     * The WordPress $admin_page_hooks.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $wpAdminPageHooks;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param array $wpMenu            The WordPress $menu global
     * @param array $wpSubmenu         The WordPress $submenu global.
     * @param array $wpSubmenuNoPriv   The WordPress $_wp_submenu_nopriv global.
     * @param array $wpRealParentFile  The WordPress $_wp_real_parent_file global.
     * @param array $wpRegisteredPages The WordPress $_registered_pages global.
     * @param array $wpParentPages     The WordPress $_parent_pages global.
     * @param array $wpAdminPageHooks  The WordPress $admin_page_hooks.
     */
    public function __construct(
        array &$wpMenu,
        array &$wpSubmenu,
        array &$wpRealParentFile,
        array &$wpSubmenuNoPriv,
        array &$wpRegisteredPages,
        array &$wpParentPages,
        array &$wpAdminPageHooks
    ) {
        $this->wpMenu            = &$wpMenu;
        $this->wpSubmenu         = &$wpSubmenu;
        $this->wpSubmenuNoPriv   = &$wpSubmenuNoPriv;
        $this->wpRealParentFile  = &$wpRealParentFile;
        $this->wpRegisteredPages = &$wpRegisteredPages;
        $this->wpParentPages     = &$wpParentPages;
        $this->wpAdminPageHooks  = &$wpAdminPageHooks;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     *
     * @return $this
     */
    public function registerMenu(MenuElementInterface $menu, $parent = null, $position = null)
    {
        $this->_registerMenu($menu, $parent, $position);

        return $this;
    }

    /**
     * Registers a top level sidebar menu.
     *
     * This method is a modified clone of the `add_menu_page()` WordPress function.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu     The menu.
     * @param int|null             $position The position.
     *
     * @return string The name of the hook when the menu is selected.
     */
    protected function _registerTopLevelMenu(MenuElementInterface $menu, $position = null)
    {
        $capability = $menu->getCapability();
        $slug       = $this->_getMenuSlug($menu);
        $callback   = $this->_getMenuHookCallback($menu);

        // Needs to exist before getting the hook name
        $this->wpAdminPageHooks[$slug] = $this->_sanitizeMenuLabel($menu);
        // Register menu hook
        $hookname = $this->_getHookName($menu);

        if (!empty($hookname) && $this->_currentUserCan($capability)) {
            $this->_addAction($hookname, $callback);
        }

        // Additional info to use in menu data array
        $iconUrl   = $this->_getMenuIconUrl($menu);
        $htmlClass = $this->_generateMenuHtmlClass($iconUrl, $hookname);

        // Check if menu is URL aware. The slug in the menu data may be a URL.
        $slugOrUrl = ($menu instanceof UrlAwareInterface)
            ? $menu->getUrl()
            : $slug;

        // Create menu data array
        $menuData = [
            static::K_MENU_LABEL      => $menu->getLabel(),
            static::K_MENU_CAPABILITY => $capability,
            static::K_MENU_SLUG       => $slugOrUrl,
            static::K_MENU_PAGE_TITLE => $this->_getPageTitle($menu),
            static::K_MENU_HTML_CLASS => $htmlClass,
            static::K_MENU_HOOK_NAME  => $hookname,
            static::K_MENU_ICON_URL   => $iconUrl,
        ];

        $this->_addMenuAtPosition($this->wpMenu, $menuData, $position);

        $this->wpRegisteredPages[$hookname] = true;
        $this->wpParentPages[$slug]         = false;

        return $hookname;
    }

    /**
     * Registers a nested sidebar menu item.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface        $menu     The menu to register.
     * @param MenuElementInterface|string $parent   The parent menu instance or slug.
     * @param int|null                    $position The position.
     *
     * @return string|null The hook name of the registered submenu, or null on failure.
     */
    protected function _registerSubMenu(MenuElementInterface $menu, $parent, $position = null)
    {
        $capability = $menu->getCapability();
        $slug       = $this->_getMenuSlug($menu);
        $parentKey  = $parent instanceof MenuElementInterface
            ? $parent->getKey()
            : $parent;
        $parentSlug = $this->_getRealParentSlug($parentKey);

        if (!$this->_currentUserCan($capability)) {
            $this->wpSubmenuNoPriv[$parentSlug][$slug] = true;

            return;
        }

        /*
         * If the submenu file is the same as the parent file someone is trying to link back to the parent manually.
         * In this case, don't automatically initialize to avoid duplicate links back to the parent.
         */
        if (!isset($this->wpSubmenu[$parentSlug]) && $slug != $parentSlug) {
            $this->_initParentSubMenus($parentSlug);
        }

        // Register menu hook
        $hookname = $this->_getHookName($menu, $parentSlug);
        if (!empty($hookname)) {
            $this->_addAction($hookname, $this->_getMenuHookCallback($menu));
        }

        // Check if menu is URL aware. The slug in the menu data may be a URL.
        $slugOrUrl = ($menu instanceof UrlAwareInterface)
            ? $menu->getUrl()
            : $slug;

        // Create menu data array
        $menuData = [
            static::K_MENU_LABEL      => $menu->getLabel(),
            static::K_MENU_CAPABILITY => $capability,
            static::K_MENU_SLUG       => $slugOrUrl,
            static::K_MENU_PAGE_TITLE => $this->_getPageTitle($menu),
        ];

        $this->_addMenuAtPosition($this->wpSubmenu[$parentSlug], $menuData, $position);

        $this->wpRegisteredPages[$hookname] = true;
        $this->wpParentPages[$slug]         = $parentSlug;

        return $hookname;
    }

    /**
     * Retrieves the WordPress hook name for a menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu       The menu.
     * @param string               $parentSlug The parent menu slug.
     *
     * @return string The hook name.
     */
    protected function _getHookName(MenuElementInterface $menu, $parentSlug = '')
    {
        return \get_plugin_page_hookname($this->_getMenuSlug($menu), $parentSlug);
    }

    /**
     * Retrieves the title of the page for a menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu the menu.
     *
     * @return string
     */
    protected function _getPageTitle(MenuElementInterface $menu)
    {
        return ($menu instanceof PageAwareInterface)
            ? $menu->getPage()->getTitle()
            : $menu->getLabel();
    }

    /**
     * Retrieves the WordPress slug for a menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu.
     *
     * @return string
     */
    protected function _getMenuSlug(MenuElementInterface $menu)
    {
        return $this->_sanitizeMenuSlug($menu->getKey());
    }

    /**
     * Sanitizes a given menu slug.
     *
     * @since [*next-version*]
     *
     * @param string $slug The menu slug to sanitize.
     *
     * @return string
     */
    protected function _sanitizeMenuSlug($slug)
    {
        return \plugin_basename($slug);
    }

    /**
     * Retrieves the label to display for a menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu.
     *
     * @return string
     */
    protected function _sanitizeMenuLabel(MenuElementInterface $menu)
    {
        return \sanitize_title($menu->getLabel());
    }

    /**
     * Retrieves the icon URL for a menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu.
     *
     * @return string
     */
    protected function _getMenuIconUrl(MenuElementInterface $menu)
    {
        $iconUrl = $menu->getIcon();

        if (empty($iconUrl)) {
            return static::DEFAULT_ICON_URL;
        }

        return \set_url_scheme($iconUrl);
    }

    /**
     * Retrieves the menu hook callback.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu.
     *
     * @return callable
     */
    protected function _getMenuHookCallback(MenuElementInterface $menu)
    {
        return [$menu, static::MENU_ON_SELECTED_METHOD];
    }

    /**
     * Generates the HTML class for a menu.
     *
     * @since [*next-version*]
     *
     * @param string $iconUrl  The menu icon url.
     * @param string $hookname The menu hook name.
     *
     * @return string
     */
    protected function _generateMenuHtmlClass($iconUrl, $hookname)
    {
        return sprintf('menu-top %1$s %2$s', $this->_generateIconHtmlClass($iconUrl), $hookname);
    }

    /**
     * Generates the HTML class for a given icon URL.
     *
     * @since [*next-version*]
     *
     * @param string $iconUrl The icon URL.
     *
     * @return string
     */
    protected function _generateIconHtmlClass($iconUrl)
    {
        if ($iconUrl === static::DEFAULT_ICON_URL) {
            return static::DEFAULT_ICON_CLASS;
        }

        return '';
    }

    /**
     * Retrieves the real parent slug, as registered in WordPress.
     *
     * @since [*next-version*]
     *
     * @param string $parentSlug The parent menu slug.
     *
     * @return string The registered parent slug.
     */
    protected function _getRealParentSlug($parentSlug)
    {
        $parentSlug = $this->_sanitizeMenuSlug($parentSlug);

        return isset($this->wpRealParentFile[$parentSlug])
            ? $this->wpRealParentFile[$parentSlug]
            : $parentSlug;
    }

    /**
     * Calculates the position.
     *
     * @since [*next-version*]
     *
     * @param $position
     * @param string $menuSlug
     * @param string $menuLabel
     *
     * @return string
     */
    protected function _calculatePosition($target, $position, $menuSlug = '', $menuLabel = '')
    {
        if ($position === null) {
            return (string) count($target);
        }

        if (isset($target["$position"])) {
            $hex = \md5($menuSlug . $menuLabel);
            $dec = \base_convert($hex, 16, 10);

            return $position + (\substr($dec, -5) * 0.00001);
        }

        return $position;
    }

    /**
     * Adds menu data to a target parent array at a specific position.
     *
     * @since [*next-version*]
     *
     * @param array    $target   The target array.
     * @param array    $menuData The menu data.
     * @param int|null $position The position index, or null to append.
     */
    protected function _addMenuAtPosition(&$target, $menuData, $position)
    {
        // Add menu data array to WordPress
        if ($position === null) {
            $target[] = $menuData;
        } else {
            $position = $this->_calculatePosition(
                $target,
                $position,
                $menuData[static::K_MENU_SLUG],
                $menuData[static::K_MENU_LABEL]
            );

            $target["$position"] = $menuData;
        }
    }

    /**
     * Initializes the submenus for a parent menu.
     *
     * If the parent does not already have any submenus, this method will add a submenu item identical to the parent
     * as the first submenu item.
     *
     * @since [*next-version*]
     *
     * @param string parentSlug The slug of the parent menu to initialize.
     *
     * @return $this
     */
    protected function _initParentSubMenus($parentSlug)
    {
        // For every registered menu
        foreach ((array) $this->wpMenu as $_parentMenu) {
            // Get slug and capability
            $_parentSlug = $_parentMenu[static::K_MENU_SLUG];
            $_parentCap  = $_parentMenu[static::K_MENU_CAPABILITY];
            // If the slug of the iteration menu is equal to the parameter and the user has the capability,
            // add the iteration menu to the parent's submenu.
            if ($_parentSlug == $parentSlug && $this->_currentUserCan($_parentCap)) {
                $this->wpSubmenu[$parentSlug][] = array_slice($_parentMenu, 0, 4);
            }
        }

        return $this;
    }

    /**
     * Registers a WordPress action.
     *
     * @since [*next-version*]
     *
     * @param string   $hookName The hook name.
     * @param callable $callable The callable to invoke.
     *
     * @return $this
     */
    protected function _addAction($hookName, $callable)
    {
        \add_action($hookName, $callable);

        return $this;
    }

    /**
     * Checks if the current user has a specific capability.
     *
     * @since [*next-version*]
     *
     * @param string $capability The capability slug.
     *
     * @return bool True if the user has the given capability, false if not.
     */
    protected function _currentUserCan($capability)
    {
        return \current_user_can($capability);
    }
}
