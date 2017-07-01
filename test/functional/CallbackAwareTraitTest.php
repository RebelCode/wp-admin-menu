<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use Xpmock\TestCase;
use RebelCode\WordPress\Admin\Menu\CallbackAwareTrait;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\CallbackAwareTrait}.
 *
 * @since [*next-version*]
 */
class CallbackAwareTraitTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\CallbackAwareTrait';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     */
    public function createInstance()
    {
        // Methods to mock
        $methods = [];
        // Create mock
        $mock = $this->getMockForTrait(
            static::TEST_SUBJECT_CLASSNAME,  [],
            '',
            true,
            true,
            true,
            $methods
        );

        return $mock;
    }

    /**
     * Tests the callback getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetCallback()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_setCallback($callback = function() { echo 'test'; });

        $this->assertSame($callback, $reflect->_getCallback());
    }

    /**
     * Tests the callback invocation method to ensure that the callback is correctly invoked with the correct args.
     *
     * @since [*next-version*]
     */
    public function testInvokeCallback()
    {
        $subject    = $this->createInstance();
        $reflect    = $this->reflect($subject);
        $called     = 0;
        $argsPassed = [];
        $args       = ['string', 1234, false, new \DateTime()];
        $callback   = function() use (&$called, &$argsPassed) {
            $called++;
            $argsPassed = func_get_args();
        };

        $reflect->_setCallback($callback);
        $reflect->_invokeCallback($args);

        $this->assertEquals(1, $called);
        $this->assertEquals($args, $argsPassed);
    }
}
