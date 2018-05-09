<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Abstract and common functionality for something that represents a WordPress menu bar.
 *
 * @since [*next-version*]
 */
abstract class AbstractMenuBar
{
    /**
     * Registers a menu with WordPress.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface             $menu
     * @param MenuElementInterface|string|null $parent
     * @param int|null                         $position
     *
     * @return $this
     */
    protected function _registerMenu(MenuElementInterface $menu, $parent = null, $position = null)
    {
        // If parent was given, register as a sub menu and disregarding children.
        if ($parent !== null) {
            $this->_registerSubMenu($menu, $parent, $position);

            return $this;
        }

        $this->_registerTopLevelMenu($menu, $position);

        foreach ($menu->getChildren() as $_position => $_child) {
            if ($_child instanceof MenuElementInterface) {
                $this->_registerSubMenu($_child, $menu, $_position);
            }
        }

        return $this;
    }

    /**
     * Registers a menu, possibly at a specific position.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu     The menu.
     * @param int|null             $position The position.
     *
     * @return string The name of the hook when the menu is selected.
     */
    abstract protected function _registerTopLevelMenu(MenuElementInterface $menu, $position = null);

    /**
     * Registers a submenu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface        $menu     The menu to register.
     * @param MenuElementInterface|string $parent   The parent menu instance or slug.
     * @param int|null                    $position The position.
     *
     * @return string|null The hook name of the registered submenu, or null on failure.
     */
    abstract protected function _registerSubMenu(MenuElementInterface $menu, $parent, $position = null);
}
