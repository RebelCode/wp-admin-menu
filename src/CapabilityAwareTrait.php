<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Something that is aware of a WordPress user capability.
 *
 * @since [*next-version*]
 */
trait CapabilityAwareTrait
{
    /**
     * The user capability.
     *
     * @since [*next-version*]
     *
     * @var string
     */
    protected $capability;

    /**
     * Gets the user capability.
     *
     * @since [*next-version*]
     *
     * @return string
     */
    protected function _getCapability()
    {
        return $this->capability;
    }

    /**
     * Sets the user capability.
     *
     * @since [*next-version*]
     *
     * @param string $capability The capability slug.
     *
     * @return $this
     */
    protected function _setCapability($capability)
    {
        $this->capability = $capability;

        return $this;
    }
}
