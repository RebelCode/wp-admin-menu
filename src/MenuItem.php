<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * The default generic implementation of a menu item that invokes a callback function when selected.
 *
 * @since [*next-version*]
 */
class MenuItem extends AbstractBaseMenuItem
{
    /*
     * This trait provides callback awareness functionality.
     *
     * @since [*next-version*]
     */
    use CallbackAwareTrait;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string        $id         The ID of this menu item.
     * @param string        $label      The label for this menu item.
     * @param string        $capability The required user capability to show this menu item.
     * @param string|null   $icon       The dashicon ID, image path or null.
     * @param callable|null $callback   The callback function to invoke when the menu item is selected.
     */
    public function __construct($id, $label, $capability, $icon = null, callable $callback = null)
    {
        $this->_construct();
        $this->_setId($id)
             ->_setLabel($label)
             ->_setCapability($capability)
             ->_setIcon($icon)
             ->_setCallback($callback);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _onSelected()
    {
        if ($this->_getCallback() !== null) {
            $this->_invokeCallback();
        }
    }
}
