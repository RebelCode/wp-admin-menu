<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Util\Normalization\NormalizeIterableCapableTrait;
use Dhii\Util\Normalization\NormalizeStringCapableTrait;
use Dhii\Validation\CreateValidationFailedExceptionCapableTrait;
use IteratorAggregate;

/**
 * Base functionality for a menu element.
 *
 * @since [*next-version*]
 */
abstract class AbstractBaseMenuElement extends AbstractMenuElement implements
    MenuElementInterface,
    IteratorAggregate
{
    /* @since [*next-version*] */
    use NormalizeStringCapableTrait;

    /* @since [*next-version*] */
    use NormalizeIterableCapableTrait;

    /* @since [*next-version*] */
    use CreateValidationFailedExceptionCapableTrait;

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
}
