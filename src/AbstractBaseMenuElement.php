<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Validation\Exception\ValidationFailedException;
use IteratorAggregate;
use RebelCode\WordPress\Admin\Menu\Iteration\RecursiveChildrenAwareIterator;

/**
 * Base functionality for a menu element.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseMenuElement extends AbstractMenuElement implements
    MenuElementInterface,
    IteratorAggregate
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
    public function hasChildren()
    {
        return $this->_hasChildren();
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
    public function getIterator()
    {
        return new RecursiveMenuIterator($this);
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
