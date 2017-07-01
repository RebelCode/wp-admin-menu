<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Base functionality for a menu.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseMenu extends AbstractBaseMenuElement implements MenuInterface
{
    /*
     * This trait provides the abstract methods for a menu.
     *
     * @since [*next-version*]
     */
    use MenuTrait;

    /**
     * {@inheritdoc}
     */
    public function getMenuItems()
    {
        return $this->_getMenuItems();
    }
}
