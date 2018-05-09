<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Something that is aware of an icon.
 *
 * @since [*next-version*]
 */
trait IconAwareTrait
{
    /**
     * The icon identifier, image path or null.
     *
     * @since [*next-version*]
     *
     * @var string|null
     */
    protected $icon;

    /**
     * Gets the icon.
     *
     * @since [*next-version*]
     *
     * @return string|null The icon identifer, image path or null.
     */
    protected function _getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets the icon.
     *
     * @since [*next-version*]
     *
     * @param string|null $icon An icon identifier, image path or null.
     *
     * @return $this
     */
    protected function _setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }
}
