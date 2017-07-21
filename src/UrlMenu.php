<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Util\String\StringableInterface;

/**
 * A menu element implementation that links to a URL.
 *
 * @since [*next-version*]
 */
class UrlMenu extends AbstractBaseMenuElement implements UrlAwareInterface
{
    /**
     * The URL.
     *
     * @since [*next-version*]
     *
     * @var string|StringableInterface
     */
    protected $url;

    /**
     * Constructor.
     *
     * @param string                     $key        The menu key.
     * @param string                     $label      The menu label.
     * @param string                     $capability The user capability required to show the menu to the user.
     * @param string|StringableInterface $url        The menu URL.
     * @param string|null                $icon       The menu icon.
     * @param array|\Traversable         $children   The child menus.
     *
     * @since [*next-version*]
     */
    public function __construct($key, $label, $capability, $url, $icon = null, $children = [])
    {
        $this->_setKey($key)
             ->_setValue($label)
             ->_setCapability($capability)
             ->_setUrl($url)
             ->_setIcon($icon)
             ->_addChildren($children)
             ->_construct();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Sets the menu URL.
     *
     * @since [*next-version*]
     *
     * @param string|StringableInterface $url The new URL.
     *
     * @return $this
     */
    protected function _setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function onSelected()
    {
        // Do nothing
    }
}
