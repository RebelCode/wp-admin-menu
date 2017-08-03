<?php

namespace unit;

use Dhii\Iterator\RecursiveIteratorInterface as R;
use RebelCode\WordPress\Admin\Menu\MenuElementInterface;
use RebelCode\WordPress\Admin\Menu\RecursiveMenuIterator;
use Xpmock\TestCase;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\RecursiveMenuIterator}.
 *
 * @since [*next-version*]
 */
class RecursiveMenuIteratorTest extends TestCase
{
    /**
     * Creates a mock menu instance for testing purposes.
     *
     * @since [*next-version*]
     *
     * @param string $key      The menu's key.
     * @param string $label    The menu's label.
     * @param array  $children The menu's children.
     *
     * @return MenuElementInterface
     */
    public function createMenuInstance($key, $label, $children = [])
    {
        $mock = $this->mock('RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface')
                     ->getKey($key)
                     ->getValue($label)
                     ->getLabel($label)
                     ->getChildren($children)
                     ->hasChildren(count($children) > 0)
                     ->getIcon()
                     ->getCapability()
                     ->onSelected();

        return $mock->new();
    }

    /**
     * Tests whether a valid instance can be created.
     *
     * @since [*next-version*]
     */
    public function testCanBeCreated()
    {
        $subject = new RecursiveMenuIterator($this->createMenuInstance('', ''));

        $this->assertInstanceOf(
            'Dhii\\Iterator\\IteratorInterface',
            $subject,
            'Subject does not implement expected interface'
        );
        $this->assertInstanceOf(
            'Dhii\\Iterator\\RecursiveIteratorInterface',
            $subject,
            'Subject does not implement expected interface'
        );
        $this->assertInstanceOf(
            'Iterator',
            $subject,
            'Subject does not implement expected interface'
        );
    }

    /**
     * Tests the iteration using MODE_SELF_FIRST mode.
     *
     * @since [*next-version*]
     */
    public function testSelfFirstIteration()
    {
        $menu    = $this->createMenuInstance('parent', '', [
            $childA = $this->createMenuInstance('childA', 'Child A'),
            $childB = $this->createMenuInstance('childB', 'Child B', [
                $grandChild1 = $this->createMenuInstance('gChild1', 'Grandchild 1'),
                $grandChild2 = $this->createMenuInstance('gChild2', 'Grandchild 2'),
            ]
            ),
            $childC = $this->createMenuInstance('childC', 'Child C', [
                $grandChild3 = $this->createMenuInstance('gChild3', 'Grandchild 3'),
            ]
            ),
        ]
        );
        $subject = new RecursiveMenuIterator($menu, R::MODE_SELF_FIRST);

        $array = iterator_to_array($subject);

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

    /**
     * Tests the iteration using MODE_CHILD_FIRST mode.
     *
     * @since [*next-version*]
     */
    public function testChildFirstIteration()
    {
        $menu    = $this->createMenuInstance('parent', '', [
            $childA = $this->createMenuInstance('childA', 'Child A'),
            $childB = $this->createMenuInstance('childB', 'Child B', [
                $grandChild1 = $this->createMenuInstance('gChild1', 'Grandchild 1'),
                $grandChild2 = $this->createMenuInstance('gChild2', 'Grandchild 2'),
            ]
            ),
            $childC = $this->createMenuInstance('childC', 'Child C', [
                $grandChild3 = $this->createMenuInstance('gChild3', 'Grandchild 3'),
            ]
            ),
        ]
        );
        $subject = new RecursiveMenuIterator($menu, R::MODE_CHILD_FIRST);

        $array = iterator_to_array($subject);

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

    /**
     * Tests the iteration using MODE_LEAVES_ONLY mode.
     *
     * @since [*next-version*]
     */
    public function testLeavesOnlyIteration()
    {
        $menu    = $this->createMenuInstance('parent', '', [
            $childA = $this->createMenuInstance('childA', 'Child A'),
            $childB = $this->createMenuInstance('childB', 'Child B', [
                $grandChild1 = $this->createMenuInstance('gChild1', 'Grandchild 1'),
                $grandChild2 = $this->createMenuInstance('gChild2', 'Grandchild 2'),
            ]
            ),
            $childC = $this->createMenuInstance('childC', 'Child C', [
                $grandChild3 = $this->createMenuInstance('gChild3', 'Grandchild 3'),
            ]
            ),
        ]
        );
        $subject = new RecursiveMenuIterator($menu, R::MODE_LEAVES_ONLY);

        $array = iterator_to_array($subject);

        $expected = [
            'childA'  => $childA,
            'gChild1' => $grandChild1,
            'gChild2' => $grandChild2,
            'gChild3' => $grandChild3,
        ];

        $this->assertEquals($expected, $array, 'Iteration result is invalid');
    }
}
