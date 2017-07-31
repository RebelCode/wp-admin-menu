<?php

namespace RebelCode\WordPress\Admin\Menu\Iteration;

use Dhii\Data\Hierarchy\ChildrenAwareInterface;
use Dhii\Data\KeyAwareInterface;
use Dhii\Iterator\AbstractRecursiveIterator;
use Dhii\Iterator\RecursiveIterationInterface;
use Dhii\Iterator\RecursiveIteratorInterface as RecursiveIterator;

/**
 * A recursive.
 *
 * @since [*next-version*]
 */
class RecursiveChildrenAwareIterator extends AbstractRecursiveIterator implements RecursiveIterator
{
    /**
     * The root element.
     *
     * @since [*next-version*]
     *
     * @var ChildrenAwareInterface
     */
    protected $root;

    /**
     * The temporary iteration instance.
     *
     * @since [*next-version*]
     *
     * @var RecursiveIterationInterface
     */
    protected $iteration;

    /**
     * The iteration mode.
     *
     * @since [*next-version*]
     *
     * @var int
     */
    protected $mode;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param ChildrenAwareInterface $root
     * @param int                    $mode
     */
    public function __construct(ChildrenAwareInterface $root, $mode = RecursiveIterator::MODE_SELF_FIRST)
    {
        $this->_setRoot($root)
             ->_setMode($mode);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function current()
    {
        return $this->_value();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function key()
    {
        return $this->_key();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function valid()
    {
        return $this->_valid();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function next()
    {
        return $this->_next();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function rewind()
    {
        return $this->_rewind();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getIteration()
    {
        return $this->_getIteration();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _isMode($mode)
    {
        return $this->mode = $mode;
    }

    /**
     * Retrieves the root element.
     *
     * @since [*next-version*]
     *
     * @return ChildrenAwareInterface
     */
    protected function _getRoot()
    {
        return $this->root;
    }

    /**
     * Sets the root element.
     *
     * @since [*next-version*]
     *
     * @param ChildrenAwareInterface $root The root element instance.
     *
     * @return $this
     */
    protected function _setRoot(ChildrenAwareInterface $root)
    {
        $this->root = $root;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _getIteration()
    {
        return $this->iteration;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _setIteration($iteration)
    {
        $this->iteration = $iteration;

        return $this;
    }

    /**
     * Retrieve the recursive iteration mode.
     *
     * @since [*next-version*]
     *
     * @return int
     */
    protected function _getMode()
    {
        return $this->mode;
    }

    /**
     * Sets the recursive iteration mode.
     *
     * @since [*next-version*]
     *
     * @param int $mode
     *
     * @return $this
     */
    protected function _setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function &_getInitialParentIterable()
    {
        $parent = $this->_getRoot();

        return $parent;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _isElementHasChildren($value)
    {
        return ($value instanceof ChildrenAwareInterface) && $value->hasChildren();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function &_getElementChildren($value)
    {
        $children = ($value instanceof ChildrenAwareInterface)
            ? $value->getChildren()
            : [];

        return $children;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _getElementPathSegment($key, $value)
    {
        return ($value instanceof KeyAwareInterface)
            ? $value->getKey()
            : null;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _createRecursiveIteration($key, $value, $path = [])
    {
        return new RecursiveIteration($key, $value, $path);
    }
}
