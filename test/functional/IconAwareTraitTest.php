<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use Xpmock\TestCase;
use RebelCode\WordPress\Admin\Menu\IconAwareTrait;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\IconAwareTrait}.
 *
 * @since [*next-version*]
 */
class IconAwareTraitTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\WordPress\Admin\Menu\IconAwareTrait';

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
     * Tests the icon getter and setter methods to ensure correct value assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetIcon()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_setIcon($icon = 'some-icon');

        $this->assertEquals($icon, $reflect->_getIcon());
    }
}
