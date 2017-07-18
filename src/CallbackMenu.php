<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Util\CallbackAwareTrait;

/**
 * A menu that invokes a callback when selected.
 *
 * @since [*next-version*]
 */
class CallbackMenu extends AbstractBaseMenuElement implements RegisterMenuCapableInterface
{
    use CallbackAwareTrait;

    /**
     * Constructor.
     *
     * @param string             $key        The menu key.
     * @param string             $label      The menu label.
     * @param string             $capability The user capability required to show the menu to the user.
     * @param string|null        $icon       The menu icon.
     * @param callable|null      $callback   The callback to invoke when the menu is selected.
     * @param array|\Traversable $children   The child menus.
     *
     * @since [*next-version*]
     */
    public function __construct($key, $label, $capability, $icon = null, callable $callback = null, $children = [])
    {
        $this->_setKey($key)
            ->_setValue($label)
            ->_setCapability($capability)
            ->_setIcon($icon)
            ->_setCallback($callback)
            ->_addChildren($children);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function registerMenu(MenuElementInterface $menu, $position = null)
    {
        $this->_addChild($menu);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function onSelected()
    {
        $this->_invokeCallback();
    }

    /**
     * Invokes the callback function.
     *
     * @since [*next-version*]
     */
    protected function _invokeCallback()
    {
        if (is_callable($callback = $this->_getCallback())) {
            call_user_func_array($callback, $this->_getCallbackArgs());
        }
    }

    /**
     * Retrieves the arguments to pass to the callback function.
     *
     * @since [*next-version*]
     *
     * @return array An array of arguments.
     */
    protected function _getCallbackArgs()
    {
        return [];
    }
}
