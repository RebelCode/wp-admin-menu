<?php

namespace RebelCode\WordPress\Admin\Menu;

use Dhii\Exception\CreateInternalExceptionCapableTrait;
use Dhii\Exception\CreateInvalidArgumentExceptionCapableTrait;
use Dhii\Exception\CreateOutOfRangeExceptionCapableTrait;
use Dhii\I18n\StringTranslatingTrait;
use Dhii\Invocation\CallbackAwareTrait;
use Dhii\Invocation\CreateInvocationExceptionCapableTrait;
use Dhii\Invocation\CreateReflectionForCallableCapableTrait;
use Dhii\Invocation\InvokeCallableCapableTrait;
use Dhii\Invocation\InvokeCallbackCapableTrait;
use Dhii\Invocation\NormalizeCallableCapableTrait;
use Dhii\Invocation\NormalizeMethodCallableCapableTrait;
use Dhii\Invocation\ValidateParamsCapableTrait;
use Dhii\Iterator\CountIterableCapableTrait;
use Dhii\Iterator\ResolveIteratorCapableTrait;
use Dhii\Util\Normalization\NormalizeArrayCapableTrait;
use Dhii\Util\Normalization\NormalizeIntCapableTrait;
use Dhii\Util\Normalization\NormalizeIterableCapableTrait;
use Dhii\Util\Normalization\NormalizeStringCapableTrait;
use Dhii\Validation\GetArgsListErrorsCapableTrait;
use Dhii\Validation\GetValidationErrorsCapableCompositeTrait;
use Dhii\Validation\GetValueTypeErrorCapableTrait;
use ReflectionFunction;
use ReflectionMethod;

/**
 * A menu that invokes a callback when selected.
 *
 * @since [*next-version*]
 */
class CallbackMenu extends AbstractBaseMenuElement
{
    /*
     * @since [*next-version*]
     */
    use CallbackAwareTrait;

    /* @since [*next-version*] */
    use InvokeCallbackCapableTrait;

    /* @since [*next-version*] */
    use InvokeCallableCapableTrait;

    use ValidateParamsCapableTrait;

    use GetArgsListErrorsCapableTrait;

    use GetValueTypeErrorCapableTrait;

    use StringTranslatingTrait;

    use CountIterableCapableTrait;

    use ResolveIteratorCapableTrait;

    use NormalizeIntCapableTrait;

    use NormalizeCallableCapableTrait;

    use NormalizeMethodCallableCapableTrait;

    use NormalizeArrayCapableTrait;

    use CreateOutOfRangeExceptionCapableTrait;

    use CreateInvalidArgumentExceptionCapableTrait;

    use CreateReflectionForCallableCapableTrait;

    use CreateInternalExceptionCapableTrait;

    use CreateInvocationExceptionCapableTrait;

    /**
     * Constructor.
     *
     * @param string             $key        The menu key.
     * @param string             $label      The menu label.
     * @param string             $capability The user capability required to show the menu to the user.
     * @param callable|null      $callback   The callback to invoke when the menu is selected.
     * @param string|null        $icon       The menu icon.
     * @param array|\Traversable $children   The child menus.
     *
     * @since [*next-version*]
     */
    public function __construct($key, $label, $capability, callable $callback = null, $icon = null, $children = [])
    {
        $this->_setKey($key);
        $this->_setValue($label);
        $this->_setCapability($capability);
        $this->_setCallback($callback);
        $this->_setIcon($icon);
        $this->_addChildren($children);
        $this->_construct();
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    public function onSelected()
    {
        $this->_invokeCallback($this->_getCallbackArgs());
    }

    /**
     * Retrieves the arguments to pass to the callback function.
     *
     * @since [*next-version*]
     *
     * @return array An array of arguments.
     */
    protected function _getCallbackArgs()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _createReflectionMethod($className, $methodName)
    {
        return new ReflectionMethod($className, $methodName);
    }

    /**
     * {@inheritdoc}
     *
     * @since [*next-version*]
     */
    protected function _createReflectionFunction($functionName)
    {
        return new ReflectionFunction($functionName);
    }
}
