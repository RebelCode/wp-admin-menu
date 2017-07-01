<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Base functionality for a menu item.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseMenuItem extends AbstractBaseMenuElement implements MenuItemInterface
{
    /*
     * This trait provides the abstract methods for a menu item.
     *
     * @since [*next-version*]
     */
    use MenuItemTrait;
}
