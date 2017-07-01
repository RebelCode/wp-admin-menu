<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

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
     * @param string      $id
     * @param string      $label
     * @param string      $cap
     * @param string|null $icon
     *
     * @return AbstractBaseMenuElement
     */
    public function createInstance($id = '', $label = '', $cap = '', $icon = '')
    {
        $mock = $this->mock(static::TEST_SUBJECT_CLASSNAME, [
            'id'          => $id,
            'label'       => $label,
            'capability'  => $cap,
            'icon'        => $icon,
            '_onSelected' => function () {}
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
     * Tests the ID getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetId()
    {
        $subject = $this->createInstance($id = 'test-123');

        $this->assertEquals($id, $subject->getId());
    }

    /**
     * Tests the label getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetLabel()
    {
        $subject = $this->createInstance('', $label = 'Test Label');

        $this->assertEquals($label, $subject->getLabel());
    }

    /**
     * Tests the capability getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetCapability()
    {
        $subject = $this->createInstance('', '', $cap = 'some_cap');

        $this->assertEquals($cap, $subject->getCapability());
    }

    /**
     * Tests the icon getter and setter methods to ensure correct assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetIcon()
    {
        $subject = $this->createInstance('', '', '', $icon = 'some_icon');

        $this->assertEquals($icon, $subject->getIcon());
    }

    /**
     * Tests the on-select method to ensure that the abstract protected method is invoked.
     *
     * @since [*next-version*]
     */
    public function testOnSelected()
    {
        $subject = $this->createInstance();
        $mock    = $subject->mock();
        $mock->_onSelected($this->once());

        $subject->onSelected();
    }
}
