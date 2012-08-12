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

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'] );
	}

	public function testAlbum()
	{
		$AlbumCollection = $this->lastfm->album()->search( 'Conspiracy of One' );

		$this->assertEquals( 'object', gettype( $AlbumCollection ) );
	}

	protected function tearDown()
	{
	}
}