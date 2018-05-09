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
            'onSelected'  => function () {},
            '__' => function ($string) { return $string; },
            '_createInvalidArgumentException' => null,
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

        $result = $subject->getChildren();

        $this->assertEquals($children, $result, '', 0, 10, true);
    }

    /**
     * Tests whether the menu can be used as an iterator to iterate over its children.
     *
     * @since [*next-version*]
     */
    public function testIteration()
    {
        $subject = $this->createInstance('parent', '', '', '', [
            $childA = $this->createInstance('childA', 'Child A'),
            $childB = $this->createInstance('childB', 'Child B', '', '', [
                $grandChild1 = $this->createInstance('gChild1','Grandchild 1'),
                $grandChild2 = $this->createInstance('gChild2','Grandchild 2'),
            ]),
            $childC = $this->createInstance('childC', 'Child C', '', '', [
                $grandChild3 = $this->createInstance('gChild3','Grandchild 3'),
            ])
        ]);

        // Ensures that we can iterate over the instance
        $array = [];
        foreach ($subject as $_key => $_val) {
            $array[$_key] = $_val;
        }

        $expected = [
            'childA'  => $childA,
            'childB'  => $childB,
            'gChild1' => $grandChild1,
            'gChild2' => $grandChild2,
            'childC'  => $childC,
            'gChild3' => $grandChild3,
        ];

        $this->assertEquals($expected, $array, 'Iteration result is invalid');
    }
}
