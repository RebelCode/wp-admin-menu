<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Basic functionality for a menu.
 *
 * @since [*next-version*]
 */
abstract class AbstractMenu extends AbstractMenuElement
{
    /*
     * This trait provides the protected methods for a menu.
     *
     * @since [*next-version*]
     */
    use MenuTrait;

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _construct()
    {
        parent::_construct();

        $this->_setMenuItems(array());
    }
}
