<?php

namespace RebelCode\WordPress\Admin\Menu;

/**
 * Base functionality for a menu element.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseMenuElement extends AbstractMenuElement implements MenuElementInterface
{
    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getKey()
    {
        return $this->_getKey();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getValue()
    {
        return $this->_getValue();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getChildren()
    {
        return $this->_getChildren();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getParent()
    {
        return $this->_getParent();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getLabel()
    {
        return $this->_getValue();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getCapability()
    {
        return $this->_getCapability();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getIcon()
    {
        return $this->_getIcon();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _createValidationFailedException(
        $message,
        $code = 0,
        $inner = null,
        $subject = null,
        $validationErrors = []
    ) {
        return new ValidationFailedException($message, $code, $inner, $subject, $validationErrors);
    }
}
