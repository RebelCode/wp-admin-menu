<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Data\Container\ContainerInterface;
use Dhii\Util\String\StringableInterface;
use WP_Admin_Bar;

/**
 * Wrapper for the WordPress Toolbar.
 *
 * @since [*next-version*]
 */
class Toolbar extends AbstractMenuBar implements RegisterMenuCapableInterface
{
    /**
     * The key of the ID in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_ID = 'id';

    /**
     * The key of the label in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_LABEL = 'title';

    /**
     * The key of the parent ID in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_PARENT = 'parent';

    /**
     * The key of the URL in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_URL = 'href';

    /**
     * The key of the group flag in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_GROUP = 'group';

    /**
     * The key of the meta sub-array in a menu data array.
     *
     * @since [*next-version*]
     */
    const K_MENU_META = 'meta';

    /**
     * The key of the HTML content in a menu data meta sub-array.
     *
     * @since [*next-version*]
     */
    const K_MENU_META_HTML = 'html';

    /**
     * The key of the HTML class attribute in a menu data meta sub-array.
     *
     * @since [*next-version*]
     */
    const K_MENU_META_CLASS = 'class';

    /**
     * The key of the HTML rel attribute in a menu data meta sub-array.
     *
     * @since [*next-version*]
     */
    const K_MENU_META_REL = 'rel';

    /**
     * The key of the HTML onclick attribute in a menu data meta sub-array.
     *
     * @since [*next-version*]
     */
    const K_MENU_META_ONCLICK = 'onclick';

    /**
     * The key of the HTML target attribute in a menu data meta sub-array.
     *
     * @since [*next-version*]
     */
    const K_MENU_META_TARGET = 'target';

    /**
     * The key of the HTML title attribute in a menu data meta sub-array.
     *
     * @since [*next-version*]
     */
    const K_MENU_META_TITLE = 'title';

    /**
     * The key of the tab index in a menu data meta sub-array.
     *
     * @since [*next-version*]
     */
    const K_MENU_META_TABINDEX = 'tabindex';

    /**
     * The format for admin page URLs.
     *
     * @since [*next-version*]
     */
    const MENU_PAGE_URL_FORMAT = 'admin.php?page=%s';

    /**
     * The WordPress Toolbar instance.
     *
     * @since [*next-version*]
     *
     * @var WP_Admin_Bar
     */
    protected $wpToolbar;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param WP_Admin_Bar $wpAdminBar The WordPress Toolbar instance.
     */
    public function __construct($wpAdminBar)
    {
        $this->_setWpToolbar($wpAdminBar);
    }

    /**
     * Retrieves the WordPress Toolbar instance.
     *
     * @since [*next-version*]
     *
     * @return WP_Admin_Bar
     */
    protected function _getWpToolbar()
    {
        return $this->wpToolbar;
    }

    /**
     * Sets the WordPress Toolbar object.
     *
     * @since [*next-version*]
     *
     * @param WP_Admin_Bar $wpToolbar The WordPress Toolbar instance.
     *
     * @return $this
     */
    protected function _setWpToolbar($wpToolbar)
    {
        $this->wpToolbar = $wpToolbar;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * The position parameter has no effect. In order to position nodes on the Toolbar, this method
     * must be called at a hook priority that matches the position for the `admin_menu_bar` action.
     *
     * @since [*next-version*]
     */
    public function registerMenu(MenuElementInterface $menu, $parent = null, $position = null)
    {
        $this->_registerMenu($menu, $parent, $position);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _registerTopLevelMenu(MenuElementInterface $menu, $position = null)
    {
        $this->_registerNode($menu, null, $position);

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _registerSubMenu(MenuElementInterface $menu, $parent, $position = null)
    {
        $this->_registerNode($menu, $parent, $position);

        return $this;
    }

    /**
     * Registers a node with the WP_Admin_Menu class.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface      $menu     The menu instance.
     * @param MenuElementInterface|null $parent   The parent menu instance, ID or null.
     * @param int|null                  $position The position.
     *
     * @return $this
     */
    protected function _registerNode(MenuElementInterface $menu, $parent = null, $position = null)
    {
        $args = $this->_prepareArgs($menu, $parent);

        $this->_getWpToolbar()->add_node($args);

        return $this;
    }

    /**
     * Prepares the menu data in a format accepted by the WP_Admin_Menu class.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface             $menu   The menu instance.
     * @param MenuElementInterface|string|null $parent The parent instance, ID or null.
     *
     * @return array
     */
    protected function _prepareArgs(MenuElementInterface $menu, $parent = null)
    {
        $menuData = [
            static::K_MENU_ID     => $menu->getKey(),
            static::K_MENU_LABEL  => $menu->getLabel(),
            static::K_MENU_PARENT => $this->_resolveParentId($parent),
            static::K_MENU_URL    => $this->_resolveMenuUrl($menu),
            static::K_MENU_GROUP  => $this->_resolveMenuGroup($menu),
            static::K_MENU_META   => $this->_prepareMenuMeta($menu),
        ];

        return $menuData;
    }

    /**
     * Resolves the parent ID for a menu.
     *
     * @since [*next-version*]
     *
     * @param $parent
     *
     * @return bool|string
     */
    protected function _resolveParentId($parent)
    {
        if ($parent === null) {
            return false;
        }

        return ($parent instanceof MenuElementInterface)
            ? $parent->getKey()
            : $parent;
    }

    /**
     * Resolves the URL for a menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu instance.
     *
     * @return StringableInterface|string The URL.
     */
    protected function _resolveMenuUrl(MenuElementInterface $menu)
    {
        if ($menu instanceof UrlAwareInterface) {
            return $menu->getUrl();
        }

        return \admin_url(sprintf(static::MENU_PAGE_URL_FORMAT, $menu->getKey()));
    }

    /**
     * Resolves whether the menu is a group or not.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu instance.
     *
     * @return bool True if the menu is a group, false if not.
     */
    protected function _resolveMenuGroup(MenuElementInterface $menu)
    {
        return false;
    }

    /**
     * Prepares the meta info for a menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu instance.
     *
     * @return array
     */
    protected function _prepareMenuMeta(MenuElementInterface $menu)
    {
        $meta = [];

        if ($menu instanceof ContainerInterface) {
            $meta[static::K_MENU_META_HTML]     = $menu->get(static::K_MENU_META_HTML);
            $meta[static::K_MENU_META_CLASS]    = $menu->get(static::K_MENU_META_CLASS);
            $meta[static::K_MENU_META_REL]      = $menu->get(static::K_MENU_META_REL);
            $meta[static::K_MENU_META_ONCLICK]  = $menu->get(static::K_MENU_META_ONCLICK);
            $meta[static::K_MENU_META_TARGET]   = $menu->get(static::K_MENU_META_TARGET);
            $meta[static::K_MENU_META_TITLE]    = $menu->get(static::K_MENU_META_TITLE);
            $meta[static::K_MENU_META_TABINDEX] = $menu->get(static::K_MENU_META_TABINDEX);
        }

        return $meta;
    }
}
