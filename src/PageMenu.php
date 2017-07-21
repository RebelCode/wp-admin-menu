<?php

namespace RebelCode\WordPress\Admin\Menu;

use RebelCode\WordPress\Admin\Page\PageAwareInterface;
use RebelCode\WordPress\Admin\Page\PageInterface;

/**
 * Implementation of a menu that renders a page.
 *
 * @since [*next-version*]
 */
class PageMenu extends AbstractBaseMenuElement implements PageAwareInterface
{
    /**
     * The page instance.
     *
     * @since [*next-version*]
     *
     * @var PageInterface
     */
    protected $page;

    /**
     * Constructor.
     *
     * @param string             $key        The menu key.
     * @param string             $label      The menu label.
     * @param string             $capability The user capability required to show the menu to the user.
     * @param PageInterface      $page       The page to render when the menu is selected.
     * @param string|null        $icon       The menu icon.
     * @param array|\Traversable $children   The child menus.
     *
     * @since [*next-version*]
     */
    public function __construct($key, $label, $capability, PageInterface $page, $icon = null, $children = [])
    {
        $this->_setKey($key)
             ->_setValue($label)
             ->_setCapability($capability)
             ->_setPage($page)
             ->_setIcon($icon)
             ->_addChildren($children)
             ->_construct();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getPage()
    {
        return $this->page;
    }

    /**
     * Sets the page instance.
     *
     * @since [*next-version*]
     *
     * @param PageInterface $page The page instance.
     *
     * @return $this
     */
    protected function _setPage($page)
    {
        $this->page = $page;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function onSelected()
    {
        echo $this->getPage()->getContent();
    }
}
