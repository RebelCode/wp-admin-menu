<?php

namespace RebelCode\WordPress\Admin\Menu\Iteration;

use Dhii\Iterator\RecursiveIterationInterface;

/**
 * Represents an iteration in a recursive iterator.
 *
 * @since [*next-version*]
 */
class RecursiveIteration implements RecursiveIterationInterface
{
    /**
     * The iteration key.
     *
     * @since [*next-version*]
     *
     * @var int|string|null
     */
    protected $key;

    /**
     * The iteration value.
     *
     * @since [*next-version*]
     *
     * @var mixed
     */
    protected $value;

    /**
     * An array of path segments.
     *
     * @since [*next-version*]
     *
     * @var array
     */
    protected $path;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param string|int|null $key   The iteration key.
     * @param mixed           $value The iteration value.
     * @param array           $path  An array of path segments.
     */
    public function __construct($key, $value, $path)
    {
        $this->key   = $key;
        $this->value = $value;
        $this->path  = $path;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getDepth()
    {
        return count($this->getPathSegments()) - 1;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getPathSegments()
    {
        return $this->path;
    }
}
