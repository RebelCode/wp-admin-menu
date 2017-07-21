<?php

namespace RebelCode\WordPress\Admin\Menu;

use ArrayIterator;
use Dhii\Validation\Exception\ValidationFailedException;
use RecursiveArrayIterator;
use RecursiveIterator;

/**
 * Base functionality for a menu element.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseMenuElement extends AbstractMenuElement implements
    MenuElementInterface,
    RecursiveIterator
{
    /**
     * Description.
     *
     * @since [*next-version*]
     *
     * @var ArrayIterator
     */
    protected $iterator;

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
        return new RecursiveArrayIterator($this->_getChildren());
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function hasChildren()
    {
        // What to do here? ChildrenAware::hasChildren() or RecursiveIterator::hasChildren() ?

        return $this->_isIterating()
            ? $this->current()->hasChildren()
            : $this->_hasChildren();
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
    public function hasParent()
    {
        return $this->_hasParent();
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
    public function rewind()
    {
        $this->iterator = new ArrayIterator($this->_getChildren());
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function valid()
    {
        return $this->iterator->valid();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function next()
    {
        $this->iterator->next();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     *
     * @return MenuElementInterface
     */
    public function current()
    {
        return $this->iterator->current();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function key()
    {
        return $this->iterator->key();
    }

    /**
     * Checks if the menu is being iterated over.
     *
     * @since [*next-version*]
     *
     * @return bool
     */
    protected function _isIterating()
    {
        return $this->iterator && $this->valid();
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
