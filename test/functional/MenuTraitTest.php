<?php

namespace RebelCode\WordPress\Admin\Menu\FuncTest;

use RebelCode\WordPress\Admin\Menu\MenuElementInterface;
use RebelCode\WordPress\Admin\Menu\MenuTrait;
use Xpmock\TestCase;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\MenuTrait}.
 *
 * @since [*next-version*]
 */
class MenuTraitTest extends TestCase
{
    /**
     * The classname of the test subject.
     *
     * @since [*next-version*]
     */
    const TEST_SUBJECT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\MenuTrait';

    /**
     * The classname of the menu element interface.
     *
     * @since [*next-version*]
     */
    const MENU_ELEMENT_CLASSNAME = 'RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface';

    /**
     * Creates a new instance of the test subject.
     *
     * @since [*next-version*]
     *
     * @return MenuTrait
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

        $this->reflect($mock)->menuItems = [];

        return $mock;
    }

    /**
     * Creates a menu element mock instance for testing purposes.
     *
     * @since [*next-version*]
     *
     * @param string      $id
     * @param string      $label
     * @param string      $cap
     * @param string|null $icon
     *
     * @return MenuElementInterface
     */
    public function createMenuElement($id = '', $label = '', $cap = '', $icon = null)
    {
        $mock = $this->mock(static::MENU_ELEMENT_CLASSNAME)
            ->getId($id)
            ->getLabel($label)
            ->getCapability($cap)
            ->getIcon($icon)
            ->onSelected();

        return $mock->new();
    }

    /**
     * Tests the menu items getter and setter methods to ensure correct value assignment and retrieval.
     *
     * @since [*next-version*]
     */
    public function testGetSetMenuItems()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $reflect->_setMenuItems($items = [
            $this->createMenuElement('test1', 'Test #1'),
            $this->createMenuElement('test2', 'Test #2')
        ]);

        $this->assertEquals($items, $reflect->_getMenuItems());
    }

    /**
     * Tests the menu items add method to ensure that menu items are correctly added to the menu.
     *
     * @since [*next-version*]
     */
    public function testAddMenuItem()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $item1 = $this->createMenuElement('test1', 'Test #1');
        $item2 = $this->createMenuElement('test2', 'Test #2');

        $reflect->_addMenuItem($item1);
        $reflect->_addMenuItem($item2);

        $this->assertEquals([$item1, $item2], $reflect->_getMenuItems());
    }

    /**
     * Tests the menu items bulk add method to ensure that all the given menu items are correctly added to the menu.
     *
     * @since [*next-version*]
     */
    public function testAddManyMenuItems()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $item1 = $this->createMenuElement('test1', 'Test #1');
        $item2 = $this->createMenuElement('test2', 'Test #2');

        $reflect->_addManyMenuItems([$item1, $item2]);

        $this->assertEquals([$item1, $item2], $reflect->_getMenuItems());
    }

    /**
     * Tests the menu items clear method to ensure that the menu items are correctly removed from the menu.
     *
     * @since [*next-version*]
     */
    public function testClearMenuItems()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $item1 = $this->createMenuElement('test1', 'Test #1');
        $item2 = $this->createMenuElement('test2', 'Test #2');

        $reflect->_setMenuItems([$item1, $item2]);
        $reflect->_clearMenuItems();

        $this->assertEmpty($reflect->_getMenuItems());
    }

    /**
     * Tests the menu item removal method to ensure that menu items are correctly removed from the menu.
     *
     * @since [*next-version*]
     */
    public function testRemoveMenuItem()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $item1 = $this->createMenuElement('test1', 'Test #1');
        $item2 = $this->createMenuElement('test2', 'Test #2');
        $item3 = $this->createMenuElement('test3', 'Test #3');

        $reflect->_setMenuItems([$item1, $item2, $item3]);
        $reflect->_removeMenuItem($item2);

        $this->assertEquals([0 => $item1, 2 => $item3], $reflect->_getMenuItems());
    }

    /**
     * Tests the menu item removal-by-index method to ensure that menu items are correctly removed from the menu.
     *
     * @since [*next-version*]
     */
    public function testRemoveMenuItemByIndex()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $item1 = $this->createMenuElement('test1', 'Test #1');
        $item2 = $this->createMenuElement('test2', 'Test #2');
        $item3 = $this->createMenuElement('test3', 'Test #3');

        $reflect->_setMenuItems([$item1, $item2, $item3]);
        $reflect->_removeMenuItemByIndex(1);

        $this->assertEquals([0 => $item1, 2 => $item3], $reflect->_getMenuItems());
    }

    /**
     * Tests the menu item index search method to ensure that menu items are correctly searched.
     *
     * @since [*next-version*]
     */
    public function testGetIndexOfMenuItem()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $item1 = $this->createMenuElement('test1', 'Test #1');
        $item2 = $this->createMenuElement('test2', 'Test #2');
        $item3 = $this->createMenuElement('test3', 'Test #3');
        $item4 = $this->createMenuElement('test4', 'Not in list!');

        $reflect->_addMenuItem($item1);
        $reflect->_addMenuItem($item2);
        $reflect->_addMenuItem($item3, 3);

        $this->assertEquals(0, $reflect->_getIndexOfMenuItem($item1));
        $this->assertEquals(1, $reflect->_getIndexOfMenuItem($item2));
        $this->assertEquals(3, $reflect->_getIndexOfMenuItem($item3));
        $this->assertEquals(false, $reflect->_getIndexOfMenuItem($item4));
    }

    /**
     * Tests the menu item existence check method to ensure that menu items are correctly searched.
     *
     * @since [*next-version*]
     */
    public function testHasMenuItem()
    {
        $subject  = $this->createInstance();
        $reflect  = $this->reflect($subject);

        $item1 = $this->createMenuElement('test1', 'Test #1');
        $item2 = $this->createMenuElement('test2', 'Test #2');
        $item3 = $this->createMenuElement('test3', 'Test #3');
        $item4 = $this->createMenuElement('test4', 'Not in list!');

        $reflect->_addMenuItem($item1);
        $reflect->_addMenuItem($item2);
        $reflect->_addMenuItem($item3, 3);

        $this->assertTrue($reflect->_hasMenuItem($item1));
        $this->assertTrue($reflect->_hasMenuItem($item2));
        $this->assertTrue($reflect->_hasMenuItem($item3));
        $this->assertFalse($reflect->_hasMenuItem($item4));
    }
}
