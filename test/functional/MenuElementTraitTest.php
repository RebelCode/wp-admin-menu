<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use Xpmock\TestCase;
use RebelCode\WordPress\Admin\Menu\MenuElementTrait;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\MenuElementTrait}.
 *
 * @since [*next-version*]
 */
class MenuElementTraitTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\MenuElementTrait';

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
     * Tests the ID getter and setter methods to ensure correct value assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetId()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $reflect->_setId($id = 'test-id-123');

        $this->assertEquals($id, $reflect->_getId());
    }

    /**
     * Tests the label getter and setter methods to ensure correct value assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetLabel()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $reflect->_setLabel($label = 'Test Label');

        $this->assertEquals($label, $reflect->_getLabel());
    }

    /**
     * Tests the capability getter and setter methods to ensure correct value assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetCapability()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $reflect->_setCapability($capability = 'some_cap');

        $this->assertEquals($capability, $reflect->_getCapability());
    }

    /**
     * Tests the icon getter and setter methods to ensure correct value assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetIcon()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $reflect->_setIcon($icon = 'some_icon');

        $this->assertEquals($icon, $reflect->_getIcon());
    }
}
