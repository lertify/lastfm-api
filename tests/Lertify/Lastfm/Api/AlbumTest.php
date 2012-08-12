<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Tests\Api;

class AlbumTest extends \PHPUnit_Framework_TestCase
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

	public function testAlbum()
	{
		$AlbumCollection = $this->lastfm->album()->search( 'Conspiracy of One' );

		//$this->assertInstanceOf( '\Lertify\Lastfm\Api\Data\Album\Collection', );
		$this->assertEquals( 'object', gettype( $AlbumCollection ) );
	}

	/**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }
}
