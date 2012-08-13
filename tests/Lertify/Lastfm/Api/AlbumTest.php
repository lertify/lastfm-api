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

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Collection', $AlbumCollection );
		$this->assertEquals( 'object', gettype( $AlbumCollection ) );
		$this->assertEquals( 1, $AlbumCollection->count() );

		/** @var $Album \Lertify\Lastfm\Api\Data\Album\Album */
		foreach ( $AlbumCollection->getAlbums() as $Album )
		{
			$this->assertEquals( 'The Offspring', $Album->getArtist() );
			$this->assertEquals( 'Conspiracy of One', $Album->getName() );
		}
	}

	public function testTopTag()
	{
		$TagCollection = $this->lastfm->album()->getTopTags( 'Radiohead', 'The Bends' );

		$this->assertGreaterThan( '1', $TagCollection->count() );
	}
}
