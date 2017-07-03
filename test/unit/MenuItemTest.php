<?php

namespace unit;

use RebelCode\WordPress\Admin\Menu\MenuItem;
use Xpmock\TestCase;

class MenuItemTest extends TestCase
{
    public function testConstructor()
    {
        $subject = new MenuItem('test', 'Test', 'some_cap', 'some_icon', function() {});

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\MenuItem',
            $subject,
            'Subject is not a valid instance.'
        );

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\MenuItemInterface',
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
        $subject = new MenuItem($id = 'test', 'Test', 'some_cap', 'some_icon', function() {});

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
        $subject = new MenuItem('test', $label = 'Test', 'some_cap', 'some_icon', function() {});

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
        $subject = new MenuItem('test', 'Test', $cap = 'some_cap', 'some_icon', function() {});

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
        $subject = new MenuItem('test', 'Test', 'some_cap', $icon = 'some_icon', function() {});

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

        $subject  = new MenuItem('test', 'Test', 'some_cap', 'some_icon', $callback);
        $subject->onSelected();

        $this->assertEquals(1, $called,
            'Callback function was called the expected number of times.');
    }
}
