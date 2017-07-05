<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Validation\Exception\ValidationFailedExceptionInterface;

/**
 * Basic functionality for menu elements.
 *
 * @since [*next-version*]
 */
abstract class AbstractMenuElement
{
    /*
     * This trait provides the protected methods for a menu element.
     *
     * @since [*next-version*]
     */
    use MenuElementTrait {
        MenuElementTrait::_addChild as _appendChild;
    }

    /**
     * Parameter-less constructor.
     *
     * Call this in the real constructor.
     *
     * @since [*next-version*]
     */
    protected function _construct()
    {
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     *
     * @param int|null $position
     */
    protected function _addChild($child, $position = null)
    {
        $this->_validateChild($child);

        if ($position === null) {
            return $this->_appendChild($child);
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
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _validateParent($parent)
    {
        if ($parent === null) {
            return;
        }

        if (!$this->_isMenuElement($parent)) {
            throw $this->_createValidationFailedException('Parent is not a valid menu element.', 0, null, $parent);
        }
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _validateChild($child)
    {
        if (!$this->_isMenuElement($child)) {
            throw $this->_createValidationFailedException('Child is not a valid menu element.', 0, null, $child);
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
