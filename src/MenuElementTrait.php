<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Basic functionality for menu elements.
 *
 * @since [*next-version*]
 */
trait MenuElementTrait
{
    /**
     * The element ID.
     *
     * @since [*next-version*]
     *
     * @var string
     */
    protected $id;

    /**
     * The element label.
     *
     * @since [*next-version*]
     *
     * @var string
     */
    protected $label;

    /**
     * The required user capability.
     *
     * @since [*next-version*]
     *
     * @var string
     */
    protected $capability;

    /**
     * The element icon; a dashicon ID, image path or null.
     *
     * @since [*next-version*]
     *
     * @var string|null
     */
    protected $icon;

    /**
     * Retrieves the unique ID of the object represented by this instance.
     *
     * @since 0.1
     *
     * @return string The ID.
     */
    protected function _getId()
    {
        return $this->id;
    }

    /**
     * Sets the element ID.
     *
     * @since [*next-version*]
     *
     * @param string $id The new ID.
     *
     * @return $this
     */
    protected function _setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Retrieves the label.
     *
     * @since [*next-version*]
     *
     * @return string
     */
    protected function _getLabel()
    {
        return $this->label;
    }

    /**
     * Sets the label of this menu element.
     *
     * @since [*next-version*]
     *
     * @param string $label The new label.
     *
     * @return $this
     */
    protected function _setLabel($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Gets the required user capability for this element to be displayed.
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
     * Sets the required user capability for this element to be displayed.
     *
     * @since [*next-version*]
     *
     * @param string $capability The capability ID.
     *
     * @return $this
     */
    protected function _setCapability($capability)
    {
        $this->capability = $capability;

        return $this;
    }

    /**
     * Gets the icon to show for this menu element.
     *
     * @since [*next-version*]
     *
     * @return string|null
     */
    protected function _getIcon()
    {
        return $this->icon;
    }

    /**
     * Sets the icon to show for this menu element.
     *
     * @since [*next-version*]
     *
     * @param string|null $icon A dashicon ID, image URL or null.
     *
     * @return $this
     */
    protected function _setIcon($icon)
    {
        $this->icon = $icon;

        return $this;
    }
}
