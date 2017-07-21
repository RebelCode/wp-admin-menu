<?php

namespace RebelCode\WordPress\Admin\Menu\UnitTest;

use RebelCode\WordPress\Admin\Menu\PageMenu;
use RebelCode\WordPress\Admin\Page\PageInterface;
use Xpmock\TestCase;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\PageMenu}.
 *
 * @since [*next-version*]
 */
class PageMenuTest extends TestCase
{
    /**
     * Creates a page mock instance.
     *
     * @since [*next-version*]
     *
     * @param string $id      The page ID.
     * @param string $title   The page title.
     * @param string $content The page content.
     *
     * @return PageInterface
     */
    protected function createPage($id = '', $title = '', $content = '')
    {
        $mock = $this->mock('RebelCode\\WordPress\\Admin\\Page\\PageInterface')
            ->getId($id)
            ->getTitle($title)
            ->getContent($content);

        return $mock->new();
    }

    /**
     * Tests the construction of a new instance to ensure that a valid instance can be created.
     *
     * @since [*next-version*]
     */
    public function testConstructor()
    {
        $subject = new PageMenu('', '', '', $this->createPage());

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Menu\\MenuElementInterface',
            $subject,
            'Subject does not implement expected interface.'
        );

        $this->assertInstanceOf(
            'Dhii\\Data\\Tree\\NodeInterface',
            $subject,
            'Subject does not implement expected interface.'
        );

        $this->assertInstanceOf(
            'RebelCode\\WordPress\\Admin\\Page\\PageAwareInterface',
            $subject,
            'Subject does not implement expected interface.'
        );
    }

    /**
     * Tests the page getter method.
     *
     * @since [*next-version*]
     */
    public function testGetPage()
    {
        $page    = $this->createPage('test', 'My Test Page', 'This is some test content.');
        $subject = new PageMenu('', '', '', $page);

        $this->assertSame($page, $subject->getPage(), 'Retrieved page and constructor page do not match.');
    }

    /**
     * Tests the menu selection method to ensure that the page content is rendered.
     *
     * @since [*next-version*]
     */
    public function testOnSelected()
    {
        $page    = $this->createPage('test', 'My Test Page', 'This is some test content.');
        $subject = new PageMenu('', '', '', $page);

        $subject->onSelected();

        $this->expectOutputString($page->getContent());
    }
}
