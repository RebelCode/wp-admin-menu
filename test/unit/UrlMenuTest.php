<?php

namespace RebelCode\WordPress\Admin\Menu\UnitTest;

use PHPUnit_Framework_TestCase;
use RebelCode\WordPress\Admin\Menu\UrlMenu;

/**
 * Tests {@see RebelCode\WordPress\Admin\Menu\UrlMenu}.
 *
 * @since [*next-version*]
 */
class UrlMenuTest extends PHPUnit_Framework_TestCase
{
    /**
     * Tests the construction of a new instance to ensure that a valid instance can be created.
     *
     * @since [*next-version*]
     */
    public function testConstructor()
    {
        $subject = new UrlMenu('', '', '', '');

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
            'Dhii\Url\UrlAwareInterface',
            $subject,
            'Subject does not implement expected interface.'
        );
    }

    /**
     * Tests the URL getter method.
     *
     * @since [*next-version*]
     */
    public function testGetUrl()
    {
        $url     = 'http://dev.test/some-url';
        $subject = new UrlMenu('', '', '', $url);

        $this->assertEquals($url, $subject->getUrl(), 'Retrieved URL and constructor URL do not match.');
    }
}
