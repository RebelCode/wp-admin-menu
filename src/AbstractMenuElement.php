<?php

namespace RebelCode\WordPress\Admin\Menu;

use Countable;
use Dhii\Data\ChildrenAwareTrait;
use Dhii\Data\KeyAwareTrait;
use Dhii\Data\ValueAwareTrait;
use Dhii\Validation\Exception\ValidationException;
use Dhii\Validation\Exception\ValidationFailedException;
use Dhii\Validation\Exception\ValidationFailedExceptionInterface;

/**
 * Basic functionality for menu elements.
 *
 * @since [*next-version*]
 */
abstract class AbstractMenuElement
{
    /*
     * @since [*next-version*]
     */
    use KeyAwareTrait;

    /*
     * @since [*next-version*]
     */
    use ValueAwareTrait;

    /*
     * @since [*next-version*]
     */
    use ChildrenAwareTrait {
        ChildrenAwareTrait::_addChild as _appendChild;
    }

    /*
     * @since [*next-version*]
     */
    use CapabilityAwareTrait;

    /*
     * @since [*next-version*]
     */
    use IconAwareTrait;

    /**
     * Parameter-less constructor.
     *
     * Call this in the real constructor.
     *
     * @since [*next-version*]
     */
    protected function _construct()
    {
        if (empty($this->children)) {
            $this->children = [];
        }
    }

    /**
     * Adds a child menu at a given position.
     *
     * @since [*next-version*]
     *
     * @param mixed    $child    The menu element to add as a child.
     * @param int|null $position An integer, with larger values signifying a lower position, or null to append.
     *
     * @throws ValidationFailedException If validation fails.
     * @throws ValidationException If an error occurs during validation.
     *
     * @return $this
     */
    protected function _addChild($child, $position = null)
    {
        $this->_validateChild($child);

        if ($position === null) {
            $this->_appendChild($child);

            return $this;
        }

        // Normalize position - detects collisions and generates new keys
        $position = $this->_normalizePosition($position, $child->getKey(), $child->getLabel());

        // Add child at determined position
        $this->children["$position"] = $child;

        // Keep the children sorted
        ksort($this->children);

        return $this;
    }

    /**
     * Checks whether this menu element has children.
     *
     * @since [*next-version*]
     *
     * @return bool True if this instance has children; false otherwise.
     */
    protected function _hasChildren()
    {
        $children = $this->_getChildren();
        $count    = 0;

        if (is_array($children) || $children instanceof Countable) {
            $count = count($children);
        }

        if ($children instanceof \Traversable) {
            $count = iterator_count($children);
        }

        return $count > 0;
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _validateChild($child)
    {
        if (!$this->_isMenuElement($child)) {
            throw $this->_createValidationFailedException('Child is not a valid menu element.', 0, null, $child, [
                'Must be an instance of MenuElementInterface'
            ]);
        }
    }

    /**
     * Checks if a given variable is a menu element instance.
     *
     * @since [*next-version*]
     *
     * @param mixed $menuElement The variable to check.
     *
     * @return bool True if the given argument is a menu element instance, false if not.
     */
    protected function _isMenuElement($menuElement)
    {
        return $menuElement instanceof MenuElementInterface;
    }

    /**
     * Normalizes the position.
     *
     * @since [*next-version*]
     *
     * @param int    $position The position.
     * @param string $key      The menu key.
     * @param string $label    The menu label.
     *
     * @return int
     */
    protected function _normalizePosition($position, $key = '', $label = '')
    {
        if (isset($this->children["$position"])) {
            $hex = \md5($key . $label);
            $dec = \base_convert($hex, 16, 10);

            return $position + \substr($dec, -5) * 0.00001;
        }

        return $position;
    }

    /**
     * Creates an exception for validation failure.
     *
     * @since [*next-version*]
     *
     * @param string                                      $message          The exception message.
     * @param int                                         $code             The exception code.
     * @param null                                        $inner            The previous exception in the chain.
     * @param mixed                                       $subject          The subject that failed validation.
     * @param string[]|StringableInterface[]|\Traversable $validationErrors The validation errors.
     *
     * @return ValidationFailedExceptionInterface
     */
    abstract protected function _createValidationFailedException(
        $message,
        $code = 0,
        $inner = null,
        $subject = null,
        $validationErrors = []
    );
}
