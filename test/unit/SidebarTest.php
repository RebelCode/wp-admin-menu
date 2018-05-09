<?php

namespace RebelCode\WordPress\Admin\Menu\UnitTest;

use RebelCode\WordPress\Admin\Menu\MenuElementInterface;
use RebelCode\WordPress\Admin\Menu\Sidebar;
use WP_Mock;
use Xpmock\TestCase;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\Sidebar}.
 *
 * @since [*next-version*]
 */
class SidebarTest extends TestCase
{
    // Mocked WordPress globals
    protected $wpMenu;
    protected $wpSubmenu;
    protected $wpSubmenuNoPriv;
    protected $wpRealParentFile;
    protected $wpRegisteredPages;
    protected $wpParentPages;
    protected $wpAdminPageHooks;

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function setUp()
    {
        WP_Mock::setUp();

        WP_Mock::passthruFunction('get_plugin_page_hookname');
        WP_Mock::passthruFunction('plugin_basename');
        WP_Mock::passthruFunction('sanitize_title');
        WP_Mock::passthruFunction('set_url_scheme');
        WP_Mock::userFunction('current_user_can', ['return' => true]);

        $this->wpMenu = [];
        $this->wpSubmenu = [];
        $this->wpSubmenuNoPriv = [];
        $this->wpRealParentFile = [];
        $this->wpRegisteredPages = [];
        $this->wpParentPages = [];
        $this->wpAdminPageHooks = [];
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function tearDown()
    {
        WP_Mock::tearDown();
    }

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return Sidebar
     */
    protected function createInstance()
    {
        return new Sidebar(
            $this->wpMenu,
            $this->wpSubmenu,
            $this->wpRealParentFile,
            $this->wpSubmenuNoPriv,
            $this->wpRegisteredPages,
            $this->wpParentPages,
            $this->wpAdminPageHooks
        );
    }

    /**
     * Creates a mocked menu instance.
     *
     * @since [*next-version*]
     *
     * @return MenuElementInterface
     */
    public function createMenu($key, $label, $children = [])
    {
        return $this->mock('RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface')
                    ->getKey($key)
                    ->getValue($label)
                    ->getChildren($children)
                    ->hasChildren()
                    ->getLabel($label)
                    ->getCapability()
                    ->getIcon()
                    ->onSelected()
                    ->new();
    }

    /**
     * Tests instance construction to ensure that a valid instance can be created.
     *
     * @requires function WP_Mock::passthruFunction
     * @requires function WP_Mock::userFunction
     *
     * @since [*next-version*]
     *
     */
    public function testConstructor()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\RegisterMenuCapableInterface',
            $subject,
            'Subject does not implement expected interface.'
        );
    }

    /**
     * Tests the registration of a top level menu to ensure that it is registered in WordPress' global variables.
     *
     * @requires function WP_Mock::passthruFunction
     * @requires function WP_Mock::userFunction
     *
     * @since [*next-version*]
     */
    public function testRegisterTopLevelMenu()
    {
        $subject = $this->createInstance();
        $menu    = $this->createMenu($key = 'my-menu', 'My Menu');

        $subject->registerMenu($menu, null);

        $this->assertArrayHasKey($key, $this->wpAdminPageHooks, 'Menu not registered to global $_admin_page_hooks.');
        $this->assertArrayHasKey($key, $this->wpParentPages, 'Menu not registered to global $_parent_pages.');
        $this->assertFalse($this->wpParentPages[$key], 'Menu was not registered as parent-less.');
    }

    /**
     * Tests the registration of a top level menu with children to ensure that all menus are registered in WordPress'
     * global variables.
     *
     * @requires function WP_Mock::passthruFunction
     * @requires function WP_Mock::userFunction
     *
     * @since [*next-version*]
     */
    public function testRegisterTopLevelMenuWithChildren()
    {
        $subject = $this->createInstance();
        $menu    = $this->createMenu($key = 'my-menu', 'My Menu', [
            $this->createMenu($keyA = 'child-a', 'Child A'),
            $this->createMenu($keyB = 'child-b', 'Child B'),
        ]);

        $subject->registerMenu($menu, null);

        $this->assertArrayHasKey($keyA, $this->wpParentPages, 'Child A not registered to global $_parent_pages.');
        $this->assertArrayHasKey($keyB, $this->wpParentPages, 'Child B not registered to global $_parent_pages.');
        $this->assertEquals($key, $this->wpParentPages[$keyA], 'Menu was not registered as parent for Child A.');
        $this->assertEquals($key, $this->wpParentPages[$keyB], 'Menu was not registered as parent for Child A.');
    }

    /**
     * Tests the registration of a submenu to ensure that all menus are registered in WordPress' global variables as a
     * child to the given parent.
     *
     * @requires function WP_Mock::passthruFunction
     * @requires function WP_Mock::userFunction
     *
     * @since [*next-version*]
     */
    public function testRegisterSubMenu()
    {
        $subject = $this->createInstance();
        $menu    = $this->createMenu($key = 'my-menu', 'My Menu');
        $child   = $this->createMenu($childKey = 'child-menu', 'Child Menu');

        $subject->registerMenu($menu, null);
        $subject->registerMenu($child, $menu);

        $this->assertArrayHasKey($childKey, $this->wpParentPages, 'Menu not registered to global $_parent_pages.');
        $this->assertEquals($menu->getKey(), $this->wpParentPages[$childKey], 'Menu was not registered as parent of child.');
    }
}
