<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\I18n\StringTranslatingTrait;
use Dhii\Iterator\AbstractBaseRecursiveIterator;
use Dhii\Iterator\ChildrenAwareRecursiveIteratorTrait;
use Dhii\Iterator\CreateIteratorExceptionCapableTrait;
use Dhii\Iterator\Exception\IteratorExceptionInterface;
use Dhii\Iterator\KeyAwareIterableTrait;
use Dhii\Iterator\RecursiveIteratorInterface as R;
use Dhii\Util\String\StringableInterface as Stringable;
use Exception as RootException;

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

    /* @since [*next-version*] */
    use StringTranslatingTrait;

    /* @since [*next-version*] */
    use CreateIteratorExceptionCapableTrait;

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

    /**
     * Throws a new iterator exception.
     *
     * @since [*next-version*]
     *
     * @param string|Stringable|null $message The error message, if any.
     * @param int|null $code The error code, if any.
     * @param RootException|null $previous The inner exception for chaining, if any.
     *
     * @return IteratorExceptionInterface The created exception.
     */
    protected function _throwIteratorException(
        $message = null,
        $code = null,
        RootException $previous = null
    ) {
        throw $this->_createIteratorException($message, $code, $previous, $this);
    }
}
