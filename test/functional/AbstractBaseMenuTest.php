<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use Xpmock\TestCase;
use RebelCode\WordPress\Admin\Menu\AbstractBaseMenu;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\AbstractBaseMenu}.
 *
 * @since [*next-version*]
 */
class AbstractBaseMenuTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\AbstractBaseMenu';

    /**
     * The classname of the menu element interface.
     *
     * @since [*next-version*]
     */
    const MENU_ELEMENT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
            ->_onSelected()
            ->new();

        return $mock;
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

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\MenuInterface', $subject,
            'Subject does not implement expected interface.'
        );

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface', $subject,
            'Subject does not implement expected interface.'
        );
    }

    /**
     * Creates a menu element mock instance for testing purposes.
     *
     * @since [*next-version*]
     *
     * @param string      $id
     * @param string      $label
     * @param string      $cap
     * @param string|null $icon
     *
     * @return MenuElementInterface
     */
    public function createMenuElement($id = '', $label = '', $cap = '', $icon = null)
    {
        $mock = $this->mock(static::MENU_ELEMENT_CLASSNAME)
             ->getId($id)
             ->getLabel($label)
             ->getCapability($cap)
             ->getIcon($icon)
             ->onSelected();

        return $mock->new();
    }

    /**
     * Tests the menu items getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetMenuItems()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $reflect->_setMenuItems($items = [
            $this->createMenuElement('test1', 'Test #1'),
            $this->createMenuElement('test2', 'Test #2')
        ]);

        $this->assertEquals($items, $reflect->_getMenuItems());
    }
}
