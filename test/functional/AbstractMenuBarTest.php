<?php


namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use RebelCode\WordPress\Admin\Menu\MenuElementInterface;
use Xpmock\TestCase;
use RebelCode\WordPress\Admin\Menu\AbstractMenuBar;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\AbstractMenuBar}.
 *
 * @since [*next-version*]
 */
class AbstractMenuBarTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\AbstractMenuBar';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return AbstractMenuBar
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
            ->_registerTopLevelMenu()
            ->_registerSubMenu()
            ->new();

        return $mock;
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
            ->getParent()
            ->getChildren([])
            ->hasChildren()
            ->getLabel()
            ->getCapability()
            ->getIcon()
            ->onSelected()
            ->new();
    }

    /**
     * Tests whether a valid instance of the test subject can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = $this->createInstance();

        $this->assertInstanceOf(
            static::TEST_SUBJECT_CLASSNAME, $subject,
            'Subject is not a valid instance'
        );
    }

    /**
     * Tests the register menu method without a parent to ensure that the top level menu registration
     * method gets called.
     *
     * @since [*next-version*]
     */
    public function testRegisterTopLevelMenu()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $menu    = $this->createMenu();

        $subject->mock()->_registerTopLevelMenu([$menu, null], $this->once());

        $reflect->_registerMenu($menu, null, null);
    }

    /**
     * Tests the register menu method without a parent to ensure that the sub menu registration
     * method gets called.
     *
     * @since [*next-version*]
     */
    public function testRegisterSubMenu()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);
        $menu    = $this->createMenu();
        $parent  = $this->createMenu();

        $subject->mock()->_registerSubMenu([$menu, $parent], $this->once());

        $reflect->_registerMenu($menu, $parent, null);
    }
}
