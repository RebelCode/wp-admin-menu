<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Basic functionality for menu elements.
 *
 * @since [*next-version*]
 */
abstract class AbstractMenuElement
{
    /*
     * This trait provides the protected methods for a menu element.
     *
     * @since [*next-version*]
     */
    use MenuElementTrait;

    /**
     * Parameter-less constructor.
     *
     * Call this in the real constructor.
     *
     * @since [*next-version*]
     */
    protected function _construct()
    {
    }
}
