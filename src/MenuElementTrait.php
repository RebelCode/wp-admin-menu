<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Data\ChildrenAwareTrait;
use Dhii\Data\KeyAwareTrait;
use Dhii\Data\ParentAwareTrait;
use Dhii\Data\ValueAwareTrait;

/**
 * Basic functionality for menu elements.
 *
 * @since [*next-version*]
 */
trait MenuElementTrait
{
    use KeyAwareTrait;
    use ValueAwareTrait;
    use ChildrenAwareTrait;
    use ParentAwareTrait;
    use CapabilityAwareTrait;
    use IconAwareTrait;
}
