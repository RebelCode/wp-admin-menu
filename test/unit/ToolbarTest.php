<?php

namespace RebelCode\WordPress\Admin\Menu\UnitTest;

use Mockery;
use RebelCode\WordPress\Admin\Menu\MenuElementInterface;
use RebelCode\WordPress\Admin\Menu\Toolbar;
use WP_Mock;
use Xpmock\TestCase;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\Toolbar}.
 *
 * @since [*next-version*]
 */
class ToolbarTest extends TestCase
{
    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function setUp()
    {
        WP_Mock::setUp();
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
     * Creates a mocked menu instance.
     *
     * @since [*next-version*]
     *
     * @return MenuElementInterface
     */
    public function createMenu()
    {
        return $this->mock('RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface')
            ->getKey()
            ->getValue()
            ->getChildren([])
            ->hasChildren()
            ->getLabel()
            ->getCapability()
            ->getIcon()
            ->onSelected()
            ->new();
    }

    /**
     * Tests instance construction to ensure that a valid instance can be created.
     *
     * @since [*next-version*]
     */
    public function testConstructor()
    {
        $wpAdminBar = Mockery::mock('\WP_Admin_Bar');
        $subject    = new Toolbar($wpAdminBar);

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\RegisterMenuCapableInterface',
            $subject,
            'Subject does not implement expected interface.'
        );
    }

    /**
     * Tests the menu registration method to ensure that the WordPress Toolbar receives the menu to add.
     *
     * @since [*next-version*]
     */
    public function testRegisterMenu()
    {
        WP_Mock::passthruFunction('admin_url', ['times' => 1]);

        $wpAdminBar = Mockery::mock('\WP_Admin_Bar');
        $wpAdminBar->shouldReceive('add_node')->once();

        $subject = new Toolbar($wpAdminBar);
        $subject->registerMenu($this->createMenu(), null, null);

        $wpAdminBar->shouldHaveReceived('add_node');
    }
}
