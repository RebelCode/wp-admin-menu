<?php

namespace RebelCode\WordPress\Admin\Menu;

use Traversable;

/**
 * Basic functionality for a menu.
 *
 * @since [*next-version*]
 */
trait MenuTrait
{
    /**
     * The menu items.
     *
     * @since [*next-version*]
     *
     * @var MenuItemInterface[]|Traversable
     */
    protected $menuItems;

    /**
     * Retrieves the items for this menu.
     *
     * @since [*next-version*]
     *
     * @return MenuItemInterface[]|Traversable
     */
    protected function _getMenuItems()
    {
        return $this->menuItems;
    }

    /**
     * Sets the items for this menu.
     *
     * @since [*next-version*]
     *
     * @param MenuItemInterface[]|Traversable $items The menu items.
     *
     * @return $this
     */
    protected function _setMenuItems($items)
    {
        $this->_clearMenuItems()
            ->_addManyMenuItems($items);
    }

    /**
     * Adds multiple menu items to this menu.
     *
     * @since [*next-version*]
     *
     * @param MenuItemInterface[]|Traversable $items The menu items to add.
     *
     * @return $this
     */
    protected function _addManyMenuItems($items)
    {
        foreach ($items as $_item) {
            $this->_addMenuItem($_item);
        }

        return $this;
    }

    /**
     * Adds a single menu item to this menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $item     The item instance to add.
     * @param int|null             $position The position of the item or null to append to the end. Default: null
     *
     * @return $this
     */
    protected function _addMenuItem(MenuElementInterface $item, $position = null)
    {
        $index = is_int($position)
            ? $position
            : count($this->menuItems);

        if (isset($this->menuItems[$index])) {
            array_splice($this->menuItems, $index, 0, array($item));

            return $this;
        }

        $this->menuItems[$index] = $item;

        return $this;
    }

    /**
     * Removes a menu item from this menu.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $item The item instance to remove.
     *
     * @return bool True if the item was found and removed, false otherwise.
     */
    protected function _removeMenuItem(MenuElementInterface $item)
    {
        $index = $this->_getIndexOfMenuItem($item);

        if ($index === false) {
            return false;
        }

        $this->_removeMenuItemByIndex($index);

        return true;
    }

    /**
     * Removes a menu item from this menu by its index.
     *
     * @since [*next-version*]
     *
     * @param int $index The index, or position, of the menu item to be removed.
     *
     * @return $this
     */
    protected function _removeMenuItemByIndex($index)
    {
        unset($this->menuItems[$index]);

        return $this;
    }

    /**
     * Retrieves the index of a menu item.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $item The item to search for.
     *
     * @return int|false If the given item was found in the menu, its index is returned. Otherwise, false is returned.
     */
    protected function _getIndexOfMenuItem(MenuElementInterface $item)
    {
        return array_search($item, $this->menuItems, true);
    }

    /**
     * Checks if this menu has a specific menu item.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $item The menu item to search for.
     *
     * @return bool True if the menu has the given menu item, false if not.
     */
    protected function _hasMenuItem(MenuElementInterface $item)
    {
        return $this->_getIndexOfMenuItem($item) !== false;
    }

    /**
     * Removes all menu items from the menu.
     *
     * @since [*next-version*]
     *
     * @return $this
     */
    protected function _clearMenuItems()
    {
        $this->menuItems = array();

        return $this;
    }
}
