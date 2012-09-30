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
		$Events = $this->lastfm->artist()->getEvents( 'Muse' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Artist\Event */
		foreach ( $Events->getPage( 1 ) as $Event )
		{
			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of ArrayCollection' );
			$this->assertGreaterThanOrEqual( 1, $Artists->count(), 'There aren\'t any artists for this event' );

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Venue', $Venue, 'Venue is not an instance of Data\Artist\Venue' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Venue->getImages(), 'Venue images are not an instance of ArrayCollection' );
		}

		$Events = $this->lastfm->artist()->getEventsByMbid( '69b39eab-6577-46a4-a9f5-817839092033' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Artist\Event */
		foreach ( $Events->getPage( 1 ) as $Event )
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

	public function testGetPastEvents()
	{
		$Events = $this->lastfm->artist()->getPastEvents( 'Сплин' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Events, 'Events are not an instance of PagedCollection' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Artist\Event */
		foreach ( $Events->getPage( 1 ) as $Event )
		{
			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of ArrayCollection' );
			$this->assertGreaterThanOrEqual( 1, $Artists->count(), 'There aren\'t any artists for this event' );

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Venue', $Venue, 'Venue is not an instance of Data\Artist\Venue' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Venue->getImages(), 'Venue images are not an instance of ArrayCollection' );
		}

		$Events = $this->lastfm->artist()->getPastEventsByMbid( '69b39eab-6577-46a4-a9f5-817839092033' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Events, 'Events are not an instance of PagedCollection' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Artist\Event */
		foreach ( $Events->getPage( 1 ) as $Event )
		{
			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of ArrayCollection' );
			$this->assertGreaterThanOrEqual( 1, $Artists->count(), 'There aren\'t any artists for this event' );

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Venue', $Venue, 'Venue is not an instance of Data\Artist\Venue' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Venue->getImages(), 'Venue images are not an instance of ArrayCollection' );
		}
	}

	public function testGetPodcast()
	{

	}

	public function testGetShouts()
	{
		$Shouts = $this->lastfm->artist()->getShouts( 'Cher' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Shouts, 'Shouts are not an instance of PagedCollection' );

		/** @var $Shout \Lertify\Lastfm\Api\Data\Artist\Shout */
		foreach ( $Shouts->getPage( 1 ) as $Shout )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Shout', $Shout, 'Shout is not an instance of Data\Artist\Shout' );
		}

		$Shouts = $this->lastfm->artist()->getShoutsByMbid( '69b39eab-6577-46a4-a9f5-817839092033' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Shouts, 'Shouts are not an instance of PagedCollection' );

		/** @var $Shout \Lertify\Lastfm\Api\Data\Artist\Shout */
		foreach ( $Shouts->getPage( 1 ) as $Shout )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Shout', $Shout, 'Shout is not an instance of Data\Artist\Shout' );
		}
	}

	public function testGetSimilar()
	{
		$Artist = $this->lastfm->artist()->getSimilar( 'Cher' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $Artist, 'Artist is not an instance of Data\Artist\Artist' );

		foreach ( $Artist->getSimilar() as $SimilarArtist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $SimilarArtist, 'SimilarArtist is not an instance of Data\Artist\Artist' );
		}

		$Artist = $this->lastfm->artist()->getSimilarByMbid( '210769a3-4aca-4199-a2e1-676ef376e078' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $Artist, 'Artist is not an instance of Data\Artist\Artist' );

		foreach ( $Artist->getSimilar() as $SimilarArtist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $SimilarArtist, 'SimilarArtist is not an instance of Data\Artist\Artist' );
		}
	}

	public function testGetTags()
	{
		$Tags = $this->lastfm->artist()->getTags( 'Cher', $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags are not an instance of ArrayCollection' );

		foreach ( $Tags as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Tag', $Tag, 'Tag is not an instance of Data\Artist\Tag' );
		}

		$Tags = $this->lastfm->artist()->getTagsAuth( 'Cher', $GLOBALS['auth_session_key'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags are not an instance of ArrayCollection' );

		foreach ( $Tags as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Tag', $Tag, 'Tag is not an instance of Data\Artist\Tag' );
		}

		$Tags = $this->lastfm->artist()->getTagsByMbid( '8bfac288-ccc5-448d-9573-c33ea2aa5c30', $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags are not an instance of ArrayCollection' );

		foreach ( $Tags as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Tag', $Tag, 'Tag is not an instance of Data\Artist\Tag' );
		}

		$Tags = $this->lastfm->artist()->getTagsByMbidAuth( '8bfac288-ccc5-448d-9573-c33ea2aa5c30', $GLOBALS['auth_session_key'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags are not an instance of ArrayCollection' );

		foreach ( $Tags as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Tag', $Tag, 'Tag is not an instance of Data\Artist\Tag' );
		}
	}
}
