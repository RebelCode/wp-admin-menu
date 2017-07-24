<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use Dhii\Validation\Exception\ValidationFailedException;
use Symfony\Component\Finder\Tests\Iterator\Iterator;
use Traversable;
use Xpmock\TestCase;
use RebelCode\WordPress\Admin\Menu\AbstractBaseMenuElement;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\AbstractBaseMenuElement}.
 *
 * @since [*next-version*]
 */
class AbstractBaseMenuElementTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\AbstractBaseMenuElement';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @param string $key
     * @param string $label
     * @param string $cap
     * @param string|null $icon
     * @param mixed $parent
     * @param array $children
     *
     * @return AbstractBaseMenuElement
     */
    public function createInstance($key = '', $label = '', $cap = '', $icon = '', $children = [])
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME, [
            'key'         => $key,
            'value'       => $label,
            'capability'  => $cap,
            'icon'        => $icon,
            'children'    => $children,
            'onSelected'  => function () {}
        ]);

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
            'RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface', $subject,
            'Subject does not implement expected interface'
        );
    }

    /**
     * Tests the key getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetKey()
    {
        $subject = $this->createInstance($key = 'test-123');

        $this->assertEquals($key, $subject->getKey());
    }

    /**
     * Tests the value getter and setter methods to ensure correct assignment and retrieval of the label.
     *
     * @since [*next-version*]
     */
    public function testGetValue()
    {
        $subject = $this->createInstance('', $label = 'Test Label');

        $this->assertEquals($label, $subject->getValue());
    }

    /**
     * Tests the label getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetLabel()
    {
        $subject = $this->createInstance('', $label = 'Test Label');

        $this->assertEquals($label, $subject->getLabel());
    }

    /**
     * Tests the capability getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetCapability()
    {
        $subject = $this->createInstance('', '', $cap = 'some_cap');

        $this->assertEquals($cap, $subject->getCapability());
    }

    /**
     * Tests the icon getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetIcon()
    {
        $subject = $this->createInstance('', '', '', $icon = 'some_icon');

        $this->assertEquals($icon, $subject->getIcon());
    }

    /**
     * Tests the parent getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetChildren()
    {
        $child1  = $this->createInstance('child1');
        $child2  = $this->createInstance('child2');
        $child3  = $this->createInstance('child3');
        $subject = $this->createInstance('', '', '', $icon = 'some_icon', $children = [$child1, $child2, $child3]);

        $result = iterator_to_array($subject->getChildren());

        $this->assertEquals($children, $result, '', 0, 10, true);
    }

    /**
     * Tests the ValidationFailedExceptionInterface creation method to ensure that it correctly creates the
     * exception instance.
     *
     * @since [*next-version*]
     */
    public function testCreateValidationFailedException()
    {
        $subject = $this->createInstance('');
        $reflect = $this->reflect($subject);

        /* @var $exception ValidationFailedException */
        $exception = $reflect->_createValidationFailedException(
            $message = 'Some exception message',
            $code = 18,
            $inner = new \Exception('Inner exception', 2, null),
            $cause = $subject,
            $errors = ['Some error', 'Another FUBAR error message']
        );

        $this->assertEquals($message, $exception->getMessage());
        $this->assertEquals($code,    $exception->getCode());
        $this->assertSame  ($inner,   $exception->getPrevious());
        $this->assertEquals($cause,   $exception->getSubject());
        $this->assertEquals($errors,  $exception->getValidationErrors());
    }

    /**
     * Tests whether the menu can be used as an iterator to iterate over its children.
     *
     * @since [*next-version*]
     */
    public function testIteration()
    {
        $subject = $this->createInstance('parent', '', '', '', [
            $childA = $this->createInstance('childA'),
            $childB = $this->createInstance('childB'),
            $childC = $this->createInstance('childC')
        ]);

        $array    = iterator_to_array($subject);
        $expected = [$childA, $childB, $childC];

        $this->assertEquals($expected, $array, 'Iteration result is invalid', 0, 10, true);
    }
}
