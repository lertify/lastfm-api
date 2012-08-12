<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Tests;

class ClientTest extends \PHPUnit_Framework_TestCase
{
	/**
     * @var \Lertify\Lastfm\Client
     */
    protected $lastfm;

	/**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'] );
    }

	/**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

	/**
     * @covers {className}::{origMethodName}
     */
    public function testGetConfiguration()
    {
        throw new \Exception( 'TODO Implement Me' );
    }
}
