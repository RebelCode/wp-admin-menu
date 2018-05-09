<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use Dhii\Validation\Exception\ValidationFailedException;
use Xpmock\TestCase;
use RebelCode\WordPress\Admin\Menu\AbstractMenuElement;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\AbstractMenuElement}.
 *
 * @since [*next-version*]
 */
class AbstractMenuElementTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\AbstractMenuElement';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     */
    public function createInstance()
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME)
            ->_createValidationFailedException(function($msg, $code = 0, $inner = null) {
                return new ValidationFailedException($msg, $code, $inner);
            })
            ->_normalizeString(function ($string) { return $string; })
            ->new();

        return $mock;
    }

    protected function createMenuElementMock()
    {
        $mock = $this->mock('RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface')
            ->getKey()
            ->getValue()
            ->getChildren()
            ->hasChildren()
            ->getLabel()
            ->getCapability()
            ->getIcon()
            ->onSelected();

        return $mock->new();
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
     * Tests the child adder method to ensure that
     *
     * @since [*next-version*]
     */
    public function testAddChild()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_addChild($child1 = $this->createMenuElementMock());
        $reflect->_addChild($child2 = $this->createMenuElementMock());

        $expected = [$child1, $child2];

        $this->assertEquals($expected, array_values($reflect->_getChildren()));
    }

    /**
     * Tests the child adder method to ensure that
     *
     * @since [*next-version*]
     */
    public function testAddChildWithPositions()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $reflect->_addChild($child1 = $this->createMenuElementMock(), 18);
        $reflect->_addChild($child2 = $this->createMenuElementMock(), 12);
        $reflect->_addChild($child3 = $this->createMenuElementMock(), 5);
        $reflect->_addChild($child4 = $this->createMenuElementMock(), 12);

        $expected = [$child3, $child2, $child4, $child1];

        $this->assertEquals($expected, array_values($reflect->_getChildren()));
    }

    /**
     * Tests the menu element instance checker method.
     *
     * @since [*next-version*]
     */
    public function testIsMenuElement()
    {
        $subject = $this->createInstance();
        $reflect = $this->reflect($subject);

        $valid   = $this->createMenuElementMock();
        $invalid = new \ArrayIterator([]);

        $this->assertTrue ($reflect->_isMenuElement($valid));
        $this->assertFalse($reflect->_isMenuElement($invalid));
        $this->assertFalse($reflect->_isMenuElement(null));
    }
}
