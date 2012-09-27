<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Tests\Api;

class ArtistTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testAddTags()
	{
		$status = $this->lastfm->artist()->addTags( 'Coldplay', array( 'Awesome' ), $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testGetCorrection()
	{
        $Artist = $this->lastfm->artist()->getCorrection( 'Metalca' );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $Artist, 'Artist is not an instance of Lertify\Lastfm\Api\Data\Artist\Artist' );

		// $Artist = $this->lastfm->artist()->getCorrection( 'Met' ); // @todo throws NotFoundException
	}

	public function testGetEvents()
	{
		$Artist = $this->lastfm->artist()->getEvents( 'Muse' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Artist\Event */
		foreach ( $Artist->getPage( 1 ) as $Event )
		{
			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of ArrayCollection' );
			$this->assertGreaterThanOrEqual( 1, $Artists->count(), 'There aren\'t any artists for this event' );

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Venue', $Venue, 'Venue is not an instance of Data\Artist\Venue' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Venue->getImages(), 'Venue images are not an instance of ArrayCollection' );
		}

		$Artist = $this->lastfm->artist()->getEventsByMbid( '69b39eab-6577-46a4-a9f5-817839092033' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Artist\Event */
		foreach ( $Artist->getPage( 1 ) as $Event )
		{
			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of ArrayCollection' );
			$this->assertGreaterThanOrEqual( 1, $Artists->count(), 'There aren\'t any artists for this event' );

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Venue', $Venue, 'Venue is not an instance of Data\Artist\Venue' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Venue->getImages(), 'Venue images are not an instance of ArrayCollection' );
		}
	}

	public function testGetInfo()
	{
		$Artist = $this->lastfm->artist()->getInfo( 'Cher' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $Artist, 'Artist is not an instance of Lertify\Lastfm\Api\Data\Artist\Artist' );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artist->getImages(), 'Artist images are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artist->getSimilar(), 'Similar artists are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artist->getTags(), 'Tags are not an instance of ArrayCollection' );

		$Artist = $this->lastfm->artist()->getInfoByMbid( '69b39eab-6577-46a4-a9f5-817839092033' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $Artist, 'Artist is not an instance of Lertify\Lastfm\Api\Data\Artist\Artist' );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artist->getImages(), 'Artist images are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artist->getSimilar(), 'Similar artists are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artist->getTags(), 'Tags are not an instance of ArrayCollection' );
	}
}
