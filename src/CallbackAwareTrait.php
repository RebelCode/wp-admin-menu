<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Something that has a callback that can be invoked with some arguments.
 *
 * @since [*next-version*]
 */
trait CallbackAwareTrait
{
    /**
     * The callback function.
     *
     * @since [*next-version*]
     *
     * @var callable
     */
    protected $callback;

    /**
     * Retrieves the callback function.
     *
     * @since [*next-version*]
     *
     * @return callable
     */
    protected function _getCallback()
    {
        return $this->callback;
    }

    /**
     * Sets the callback function.
     *
     * @since [*next-version*]
     *
     * @param callable $callback The callback function.
     *
     * @return $this
     */
    protected function _setCallback(callable $callback = null)
    {
        $this->callback = $callback;

        return $this;
    }

    /**
     * Invokes the callback function.
     *
     * @since [*next-version*]
     *
     * @param array $args The arguments to pass to the callback function.
     *
     * @return mixed The return value of the callback function.
     */
    protected function _invokeCallback(array $args = array())
    {
        return call_user_func_array($this->_getCallback(), $args);
    }
}
