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
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testSearch()
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

	public function testGetTopTag()
	{
		$TagCollection = $this->lastfm->album()->getTopTags( 'Radiohead', 'The Bends' );

		$this->assertGreaterThan( '1', $TagCollection->count() );

		$TagCollection = $this->lastfm->album()->getTopTagsByMbid( '0405cb4c-fc88-3338-b5d6-1fa71a9562e4' );

		$this->assertGreaterThan( '1', $TagCollection->count() );

		//$this->assertEquals( 100, $TagCollection->count() );
	}

	public function testGetInfo()
	{
		$Album = $this->lastfm->album()->getInfo( 'The Offspring', 'Conspiracy of One' );

		$this->assertEquals( 14, $Album->getTracks()->count() );

		$Album = $this->lastfm->album()->getInfo( 'Cher', 'Believe' );

		$this->assertNotEmpty( $Album->getWikiSummary() );
	}
}