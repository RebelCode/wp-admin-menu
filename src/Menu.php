<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * The default generic implementation of a menu that invokes a callback function when selected.
 *
 * @since [*next-version*]
 */
class Menu extends AbstractBaseMenu implements WriteableMenuInterface
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
     * @param string        $id         The ID of this menu.
     * @param string        $label      The label for this menu.
     * @param string        $capability The required user capability to show this menu.
     * @param string|null   $icon       The dashicon ID, image path or null.
     * @param callable|null $callback   The callback function to invoke when the menu is selected.
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
    public function addMenuItem(MenuElementInterface $menuItem, $position = null)
    {
        $this->_addMenuItem($menuItem, $position);

        return $this;
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
