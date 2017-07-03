<?php

namespace unit;

use RebelCode\WordPress\Admin\Menu\Menu;
use Xpmock\TestCase;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\Menu}.
 *
 * @since [*next-version*]
 */
class MenuTest extends TestCase
{
    public function createMenuItem($id, $label)
    {
        $mock = $this->mock('RebelCode\\WordPress\\Admin\\Menu\\MenuItemInterface')
            ->getId($id)
            ->getLabel($label)
            ->getCapability()
            ->getIcon()
            ->onSelected()
            ->new();

        return $mock;
    }

    /**
     * Tests the constructor to assert whether a correct instance is created.
     *
     * @since [*next-version*]
     */
    public function testConstructor()
    {
        $subject = new Menu('test', 'Test', 'some_cap', 'some_icon', function() {});

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\Menu',
            $subject,
            'Subject is not a valid instance.'
        );

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\MenuInterface',
            $subject,
            'Subject does not implement expected interface'
        );

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface',
            $subject,
            'Subject does not implement expected interface'
        );
    }

    /**
     * Tests the ID getter to ensure correct value retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetId()
    {
        $subject = new Menu($id = 'test', 'Test', 'some_cap', 'some_icon', function() {});

        $this->assertEquals($id, $subject->getId(),
            'Retrieved ID does not match ID given in constructor.');
    }

    /**
     * Tests the label getter to ensure correct value retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetLabel()
    {
        $subject = new Menu('test', $label = 'Test', 'some_cap', 'some_icon', function() {});

        $this->assertEquals($label, $subject->getLabel(),
            'Retrieved label does not match label given in constructor.');
    }

    /**
     * Tests the capability getter to ensure correct value retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetCapability()
    {
        $subject = new Menu('test', 'Test', $cap = 'some_cap', 'some_icon', function() {});

        $this->assertEquals($cap, $subject->getCapability(),
            'Retrieved capability does not match capability given in constructor.');
    }

    /**
     * Tests the icon getter to ensure correct value retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetIcon()
    {
        $subject = new Menu('test', 'Test', 'some_cap', $icon = 'some_icon', function() {});

        $this->assertEquals($icon, $subject->getIcon(),
            'Retrieved icon does not match icon given in constructor.');
    }

    /**
     * Tests the on-select function to ensure that the callback set during construction is called correctly.
     *
     * @since [*next-version*]
     */
    public function testOnSelected()
    {
        $called   = 0;
        $callback = function() use (&$called) {
            $called++;
        };

        $subject  = new Menu('test', 'Test', 'some_cap', 'some_icon', $callback);
        $subject->onSelected();

        $this->assertEquals(1, $called,
            'Callback function was called the expected number of times.');
    }

    /**
     * Tests the menu items addition and getter methods to ensure that menu items are correctly added and retrieved.
     *
     * @since [*next-version*]
     */
    public function testGetAddMenuItems()
    {
        $subject  = new Menu('test', 'Test', 'some_cap');

        $item1 = $this->createMenuItem('item1', 'Item #1');
        $item2 = $this->createMenuItem('item2', 'Item #2');

        $subject->addMenuItem($item1);
        $subject->addMenuItem($item2);

        $this->assertEquals([$item1, $item2], $subject->getMenuItems(),
            'Retrieved menu items do not match the items added.');
    }
}
