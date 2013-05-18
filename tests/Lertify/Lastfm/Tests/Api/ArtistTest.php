<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class ArtistTest extends Setup
{
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
		// @todo Can't implement at the moment, due to missing viable working example
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

	public function testGetTopAlbums()
	{
		$TopAlbums = $this->lastfm->artist()->getTopAlbums( 'Paramore' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopAlbums, 'TopAlbums are not an instance of PagedCollection' );

		/** @var $TopAlbum \Lertify\Lastfm\Api\Data\Artist\Album */
		foreach ( $TopAlbums->getPage( 1 ) as $TopAlbum )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Album', $TopAlbum, 'TopAlbum is not an instance of Data\Artist\Album' );

			$Artist = $TopAlbum->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $Artist, 'TopAlbum is not an instance of Data\Artist\Artist' );

			$AlbumImages = $TopAlbum->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $AlbumImages, 'TopAlbum is not an instance of Data\ArrayCollection' );
		}

		$TopAlbums = $this->lastfm->artist()->getTopAlbumsByMbid( 'f59c5520-5f46-4d2c-b2c4-822eabf53419' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopAlbums, 'TopAlbums are not an instance of PagedCollection' );

		/** @var $TopAlbum \Lertify\Lastfm\Api\Data\Artist\Album */
		foreach ( $TopAlbums->getPage( 1 ) as $TopAlbum )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Album', $TopAlbum, 'TopAlbum is not an instance of Data\Artist\Album' );

			$Artist = $TopAlbum->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $Artist, 'TopAlbum is not an instance of Data\Artist\Artist' );

			$AlbumImages = $TopAlbum->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $AlbumImages, 'TopAlbum is not an instance of Data\ArrayCollection' );
		}
	}

	public function testGetTopFans()
	{
		$TopFans = $this->lastfm->artist()->getTopFans( 'zzzzz' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopFans, 'TopFans is not an instance of Data\ArrayCollection' );

		/** @var $TopFan \Lertify\Lastfm\Api\Data\Artist\Fan */
		foreach ( $TopFans as $TopFan )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Fan', $TopFan, 'TopFan is not an instance of Data\Artist\Fan' );

			$TopFanImages = $TopFan->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopFanImages, 'TopFansImages is not an instance of Data\ArrayCollection' );
		}

		$TopFans = $this->lastfm->artist()->getTopFansByMbid( '3cc05480-ecb7-4527-8922-1e853b90a284' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopFans, 'TopFans is not an instance of Data\ArrayCollection' );

		/** @var $TopFan \Lertify\Lastfm\Api\Data\Artist\Fan */
		foreach ( $TopFans as $TopFan )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Fan', $TopFan, 'TopFan is not an instance of Data\Artist\Fan' );

			$TopFanImages = $TopFan->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopFanImages, 'TopFansImages is not an instance of Data\ArrayCollection' );
		}
	}

	public function testGetTopTags()
	{
		$TopTags = $this->lastfm->artist()->getTopTags( 'Paramore' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTags, 'TopTags is not an instance of Data\ArrayCollection' );

		/** @var $TopTag \Lertify\Lastfm\Api\Data\Tag */
		foreach ( $TopTags as $TopTag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag', $TopTag, 'TopTag is not an instance of Data\Tag' );
		}

		$TopTags = $this->lastfm->artist()->getTopTagsByMbid( 'f59c5520-5f46-4d2c-b2c4-822eabf53419' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTags, 'TopTags is not an instance of Data\ArrayCollection' );

		/** @var $TopTag \Lertify\Lastfm\Api\Data\Tag */
		foreach ( $TopTags as $TopTag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag', $TopTag, 'TopTag is not an instance of Data\Tag' );
		}
	}

	public function testGetTopTracks()
	{
		$TopTracks = $this->lastfm->artist()->getTopTracks( 'Paramore' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopTracks, 'TopAlbums are not an instance of PagedCollection' );

		/** @var $TopTrack \Lertify\Lastfm\Api\Data\Artist\Track */
		foreach ( $TopTracks->getPage( 1 ) as $TopTrack )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Track', $TopTrack, 'TopTrack is not an instance of Data\Artist\Track' );

			$TrackImages = $TopTrack->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages is not an instance of Data\ArrayCollection' );
		}

		$TopTracks = $this->lastfm->artist()->getTopTracksByMbid( 'f59c5520-5f46-4d2c-b2c4-822eabf53419' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopTracks, 'TopAlbums are not an instance of PagedCollection' );

		/** @var $TopTrack \Lertify\Lastfm\Api\Data\Artist\Track */
		foreach ( $TopTracks->getPage( 1 ) as $TopTrack )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Track', $TopTrack, 'TopTrack is not an instance of Data\Artist\Track' );

			$TrackImages = $TopTrack->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages is not an instance of Data\ArrayCollection' );
		}
	}

	public function testRemoveTag()
	{
		$status = $this->lastfm->artist()->removeTag( 'Coldplay', 'Awesome', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testSearch()
	{
		$Artists = $this->lastfm->artist()->search( 'decode' );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Artists are not an instance of PagedCollection' );
		$this->assertEquals( 'object', gettype( $Artists ) );
		$this->assertGreaterThanOrEqual( 1, $Artists->count() );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Artist\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist\Artist', $Artist, 'Artist is not an instance of Data\Artist\Artist' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages is not an instance of Data\ArrayCollection' );
		}
	}

	public function testShare()
	{
		$status = $this->lastfm->artist()->share( 'Paramore', $GLOBALS['tests_email'], $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testShout()
	{
		$status = $this->lastfm->artist()->shout( 'Paramore', 'Awesome band', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}
}
