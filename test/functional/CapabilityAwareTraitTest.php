<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use Xpmock\TestCase;
use RebelCode\WordPress\Admin\Menu\CapabilityAwareTrait;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\CapabilityAwareTrait}.
 *
 * @since [*next-version*]
 */
class CapabilityAwareTraitTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\WordPress\Admin\Menu\CapabilityAwareTrait';

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
     * Tests the capability getter and setter methods to ensure correct value assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetCapability()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_setCapability($cap = 'some_capability');

        $this->assertEquals($cap, $reflect->_getCapability());
    }
}
