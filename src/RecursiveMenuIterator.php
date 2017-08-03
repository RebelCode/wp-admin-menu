<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Iterator\AbstractBaseRecursiveIterator;
use Dhii\Iterator\ChildrenAwareRecursiveIteratorTrait;
use Dhii\Iterator\KeyAwareIterableTrait;
use Dhii\Iterator\RecursiveIteratorInterface as R;

/**
 * A recursive iterator that iterates over a menu's children and all other nested descendents.
 *
 * @since [*next-version*]
 */
class RecursiveMenuIterator extends AbstractBaseRecursiveIterator
{
    /*
     * Provides functionality to determine the key and path segment from a
     * key-aware iterable element.
     *
     * @since [*next-version*]
     */
    use KeyAwareIterableTrait;

    /*
     * Provides functionality to determine children from a children-aware
     * iterable element.
     *
     * @since [*next-version*]
     */
    use ChildrenAwareRecursiveIteratorTrait;

    /**
     * The menu to iterate over.
     *
     * @since [*next-version*]
     *
     * @var MenuElementInterface
     */
    protected $menu;

    /**
     * Constructor.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu to iterate over.
     */
    public function __construct(MenuElementInterface $menu, $mode = R::MODE_SELF_FIRST)
    {
        $this->_setMenu($menu)
            ->_setMode($mode);
    }

    /**
     * Retrieves the menu that is to be iterated over.
     *
     * @since [*next-version*]
     *
     * @return MenuElementInterface
     */
    protected function _getMenu()
    {
        return $this->menu;
    }

    /**
     * Sets the menu to iterate over.
     *
     * @since [*next-version*]
     *
     * @param MenuElementInterface $menu The menu to iterate over.
     *
     * @return $this
     */
    protected function _setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function &_getInitialParentIterable()
    {
        $menu = $this->_getMenu();

        return $menu;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _getCurrentIterableValue(&$iterable)
    {
        return current($iterable);
    }
}
