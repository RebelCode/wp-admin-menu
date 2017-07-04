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

    public function testNothing() {}
}
