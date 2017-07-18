<?php

namespace unit;

use PHPUnit_Framework_TestCase;
use RebelCode\WordPress\Admin\Menu\CallbackMenu;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\CallbackMenu}.
 *
 * @since [*next-version*]
 */
class CallbackMenuTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests the construction of a new instance to ensure that a valid instance can be created.
     *
     * @since [*next-version*]
     */
    public function testConstructor()
    {
        $subject = new CallbackMenu('', '', '');

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface',
            $subject,
            'Subject does not implement expected interface.'
        );

        $this->assertInstanceOf(
            'Dhii\\Data\\Tree\\NodeInterface',
            $subject,
            'Subject does not implement expected interface.'
        );
    }

    /**
     * Tests the on-select method to ensure that the callback gets invoked.
     *
     * @since [*next-version*]
     */
    public function testOnSelect()
    {
        $called   = 0;
        $callback = function() use (&$called) {
            $called++;
        };

        $subject = new CallbackMenu('', '', '', '', $callback);

        $subject->onSelected();

        $this->assertEquals(1, $called,
            sprintf('Callback was expected to be called once. Called %d times.', $called));
    }
}
