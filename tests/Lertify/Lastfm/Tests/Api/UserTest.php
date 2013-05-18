<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class UserTest extends Setup
{
	/**
	 * @return void
	 */
	public function testGetArtistTracks()
	{
		$Tracks = $this->lastfm->user()->getArtistTracks( 'Coldplay', $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\User\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Track', $Track, 'Track is not an instance of \Lertify\Lastfm\Api\Data\User\Track!' );

			$Artist = $Track->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );

			$Album = $Track->getAlbum();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Album', $Album, 'Album is not an instance of \Lertify\Lastfm\Api\Data\User\Album!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album', $Album, 'Album is not an instance of \Lertify\Lastfm\Api\Data\Album!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'Track images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetBannedTracks()
	{
		$Tracks = $this->lastfm->user()->getBannedTracks( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\User\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Track', $Track, 'Track is not an instance of \Lertify\Lastfm\Api\Data\User\Track!' );

			$Artist = $Track->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'Track images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetEvents()
	{
		$Events = $this->lastfm->user()->getEvents( $GLOBALS['tests_username'], false );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Events, 'Events are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $Event \Lertify\Lastfm\Api\Data\User\Event */
		foreach ( $Events->getPage( 1 ) as $Event )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Event', $Event, 'Event is not an instance of \Lertify\Lastfm\Api\Data\User\Event!' );

			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			/** @var $Artist \Lertify\Lastfm\Api\Data\User\Artist */
			foreach ( $Artists as $Artist )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
			}

			$Headliner = $Event->getHeadliner();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Headliner, 'Headliner is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Headliner, 'Headliner is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Venue', $Venue, 'Venue is not an instance of \Lertify\Lastfm\Api\Data\User\Venue!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue', $Venue, 'Venue is not an instance of \Lertify\Lastfm\Api\Data\Venue!' );

			$VenueImages = $Venue->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $VenueImages, 'Venue images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			$EventImages = $Event->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $EventImages, 'Event images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );

			$Tags = $Event->getTags();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );

			/** @var $Tag \Lertify\Lastfm\Api\Data\User\Tag */
			foreach ( $Tags as $Tag )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Tag', $Tag, 'Tag is not an instance of \Lertify\Lastfm\Api\Data\User\Tag!' );
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag', $Tag, 'Tag is not an instance of \Lertify\Lastfm\Api\Data\Tag!' );
			}
		}
	}

	/**
	 * @return void
	 */
	public function testGetFriends()
	{
		$Friends = $this->lastfm->user()->getFriends( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Friends, 'Friends are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $User \Lertify\Lastfm\Api\Data\User\User */
		foreach ( $Friends->getPage( 1 ) as $User )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\User', $User, 'User is not an instance of \Lertify\Lastfm\Api\Data\User\User!' );
			$this->assertInstanceOf( 'DateTime', $User->getRegisteredAt(), 'User registration date is not an instance of \DateTime!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $User->getImages(), 'User images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );

			$RecentTrack = $User->getRecentTrack();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Track', $RecentTrack, 'Recent track is not an instance of \Lertify\Lastfm\Api\Data\User\Track!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Album', $RecentTrack->getAlbum(), 'Recent track album is not an instance of \Lertify\Lastfm\Api\Data\User\Album!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $RecentTrack->getArtist(), 'Recent track artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetInfo()
	{
		$User = $this->lastfm->user()->getInfo( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\User', $User, 'User is not an instance of \Lertify\Lastfm\Api\Data\User\User!' );
		$this->assertInstanceOf( 'DateTime', $User->getRegisteredAt(), 'User registration date is not an instance of \DateTime!' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $User->getImages(), 'User images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );
	}

	/**
	 * @return void
	 */
	public function testGetLovedTracks()
	{
		$Tracks = $this->lastfm->user()->getLovedTracks( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Friends are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var \Lertify\Lastfm\Api\Data\User\Track $Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Track', $Track, 'Track is not an instance of \Lertify\Lastfm\Api\Data\User\Track!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Track->getArtist(), 'Track artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Track->getImages(), 'Track images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );
			$this->assertInstanceOf( 'DateTime', $Track->getLovedAt(), 'Track loved date is not an instance of \DateTime!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetNeighbours()
	{
		$Neighbours = $this->lastfm->user()->getNeighbours( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Neighbours, 'Neighbours are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );

		/** @var $Neighbour \Lertify\Lastfm\Api\Data\User\User */
		foreach ( $Neighbours as $Neighbour )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\User', $Neighbour, 'Neighbour is not an instance of \Lertify\Lastfm\Api\Data\User\User!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Neighbour->getImages(), 'Neighbour images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetNewReleases()
	{
		$Albums = $this->lastfm->user()->getNewReleases( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Albums, 'Albums are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

		foreach ( $Albums as $Album )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Album', $Album, 'Album is not an instance of \Lertify\Lastfm\Api\Data\User\Album!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album', $Album, 'Album is not an instance of \Lertify\Lastfm\Api\Data\Album!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Album->getArtist(), 'Album artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Album->getArtist(), 'Album artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Album->getImages(), 'Album images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetPastEvents()
	{
		$PastEvents = $this->lastfm->user()->getPastEvents( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $PastEvents, 'Past events are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $PastEvent \Lertify\Lastfm\Api\Data\User\Event */
		foreach ( $PastEvents->getPage( 1 ) as $PastEvent )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Event', $PastEvent, 'Past event is not an instance of \Lertify\Lastfm\Api\Data\User\Event!' );
			$this->assertInstanceOf( 'DateTime', $PastEvent->getStartDate(), 'Past event start date is not an instance of \DateTime!' );

			$Artists = $PastEvent->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Event artists are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			/** @var $Artist \Lertify\Lastfm\Api\Data\User\Artist */
			foreach ( $Artists as $Artist )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
			}

			$Headliner = $PastEvent->getHeadliner();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Headliner, 'Event headliner is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Headliner, 'Event headliner is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $PastEvent->getImages(), 'Past event images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			$Venue = $PastEvent->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Venue', $Venue, 'Event venue is not an instance of \Lertify\Lastfm\Api\Data\User\Venue!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue', $Venue, 'Event venue is not an instance of \Lertify\Lastfm\Api\Data\Venue!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Venue->getImages(), 'Event venue images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			if ( null !== ( $EndDate = $PastEvent->getEndDate() ) )
			{
				$this->assertInstanceOf( 'DateTime', $EndDate, 'Past event end date is not an instance of \DateTime!' );
			}
		}
	}

	/**
	 * @return void
	 */
	public function testGetPersonalTagsForArtist()
	{
		$Artists = $this->lastfm->user()->getPersonalTagsForArtist( $GLOBALS['tests_username'], 'rock' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Artists are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\User\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artist->getImages(), 'Artist images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetPersonalTagsForAlbum()
	{
		$Albums = $this->lastfm->user()->getPersonalTagsForAlbum( $GLOBALS['tests_username'], 'rock' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Albums, 'Albums are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $Album \Lertify\Lastfm\Api\Data\User\Album */
		foreach ( $Albums->getPage( 1 ) as $Album )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Album', $Album, 'Album is not an instance of \Lertify\Lastfm\Api\Data\User\Album!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album', $Album, 'Album is not an instance of \Lertify\Lastfm\Api\Data\Album!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Album->getImages(), 'Album images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			$Artist = $Album->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetPersonalTagsForTrack()
	{
		$Tracks = $this->lastfm->user()->getPersonalTagsForTrack( $GLOBALS['tests_username'], 'rock' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\User\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Track', $Track, 'Track is not an instance of \Lertify\Lastfm\Api\Data\User\Track!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track', $Track, 'Track is not an instance of \Lertify\Lastfm\Api\Data\Track!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Track->getImages(), 'Track images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			$Artist = $Track->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetPlaylists()
	{
		$Playlists = $this->lastfm->user()->getPlaylists( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Playlists, 'Playlists are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

		/** @var $Playlist \Lertify\Lastfm\Api\Data\User\Playlist */
		foreach ( $Playlists as $Playlist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Playlist', $Playlist, 'Playlist is not an instance of \Lertify\Lastfm\Api\Data\User\Playlist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\Playlist', $Playlist, 'Playlist is not an instance of \Lertify\Lastfm\Api\Data\Playlist\Playlist!' );

			$this->assertInstanceOf( 'DateTime', $Playlist->getDate(), 'Playlist create date is not an instance of \DateTime!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Playlist->getImages(), 'Playlist images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetRecentStations()
	{
		$Stations = $this->lastfm->user()->getRecentStations( $GLOBALS['tests_username'], $GLOBALS['auth_session_key'] );
		$Stations->getPage( 1 );
	}

	/**
	 * @return void
	 */
	public function testGetRecentTracks()
	{
		$RecentTracks = $this->lastfm->user()->getRecentTracks( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $RecentTracks, 'Recent tracks are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $RecentTrack \Lertify\Lastfm\Api\Data\User\Track */
		foreach ( $RecentTracks->getPage( 1 ) as $RecentTrack )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Track', $RecentTrack, 'Recent track is not an instance of \Lertify\Lastfm\Api\Data\User\Track!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track', $RecentTrack, 'Recent track is not an instance of \Lertify\Lastfm\Api\Data\Track!' );

			$this->assertInstanceOf( 'DateTime', $RecentTrack->getPlayedAt(), 'Recent track played date is not an instance of \DateTime!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $RecentTrack->getImages(), 'Recent track images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			$Artist = $RecentTrack->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );

			$Album = $RecentTrack->getAlbum();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Album', $Album, 'Album is not an instance of \Lertify\Lastfm\Api\Data\User\Album!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album', $Album, 'Album is not an instance of \Lertify\Lastfm\Api\Data\Album!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetRecommendedArtists()
	{
		$RecommendedArtists = $this->lastfm->user()->getRecommendedArtists( $GLOBALS['auth_session_key'] );
		$RecommendedArtists->getPage( 1 );
	}

	/**
	 * @return void
	 */
	public function testGetRecommendedEventsByCoordinates()
	{
		$RecommendedEvents = $this->lastfm->user()->getRecommendedEventsByCoordinates( $GLOBALS['auth_session_key'] );
		$RecommendedEvents->getPage( 1 );
	}

	/**
	 * @return void
	 */
	public function testGetRecommendedEventsByCountry()
	{
		$RecommendedEvents = $this->lastfm->user()->getRecommendedEventsByCountry( $GLOBALS['auth_session_key'] );
		$RecommendedEvents->getPage( 1 );
	}

	/**
	 * @return void
	 */
	public function testGetShouts()
	{
		$Shouts = $this->lastfm->user()->getShouts( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Shouts, 'Shouts are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $Shout \Lertify\Lastfm\Api\Data\User\Shout */
		foreach ( $Shouts->getPage( 1 ) as $Shout )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Shout', $Shout, 'Shout is not an instance of \Lertify\Lastfm\Api\Data\User\Shout!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Shout', $Shout, 'Shout is not an instance of \Lertify\Lastfm\Api\Data\Shout!' );

			$this->assertInstanceOf( 'DateTime', $Shout->getDate(), 'Shout date is not an instance of \DateTime!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\User', $Shout->getAuthor(), 'Shout author is not an instance of \Lertify\Lastfm\Api\Data\User\User!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTopAlbums()
	{
		$TopAlbums = $this->lastfm->user()->getTopAlbums( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopAlbums, 'Top albums are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $TopAlbum \Lertify\Lastfm\Api\Data\User\Album */
		foreach ( $TopAlbums->getPage( 1 ) as $TopAlbum )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Album', $TopAlbum, 'Top album is not an instance of \Lertify\Lastfm\Api\Data\User\Album!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album', $TopAlbum, 'Top album is not an instance of \Lertify\Lastfm\Api\Data\Album!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopAlbum->getImages(), 'Top album images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			$Artist = $TopAlbum->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTopArtists()
	{
		$TopArtists = $this->lastfm->user()->getTopArtists( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopArtists, 'Top albums are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $TopArtist \Lertify\Lastfm\Api\Data\User\Artist */
		foreach ( $TopArtists->getPage( 1 ) as $TopArtist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $TopArtist, 'Top artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $TopArtist, 'Top artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopArtist->getImages(), 'Top artist images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTopTags()
	{
		$TopTags = $this->lastfm->user()->getTopTags( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTags, 'Top tags are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

		foreach ( $TopTags as $TopTag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Tag', $TopTag, 'Top tag is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag', $TopTag, 'Top tag is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTopTracks()
	{
		$TopTracks = $this->lastfm->user()->getTopTracks( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopTracks, 'Top tracks are not an instance of \Lertify\Lastfm\Api\Data\PagedCollection!' );

		/** @var $TopTrack \Lertify\Lastfm\Api\Data\User\Track */
		foreach ( $TopTracks->getPage( 1 ) as $TopTrack )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Track', $TopTrack, 'Top track is not an instance of \Lertify\Lastfm\Api\Data\User\Track!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track', $TopTrack, 'Top track is not an instance of \Lertify\Lastfm\Api\Data\Track!' );

			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTrack->getImages(), 'Top track images are not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

			$Artist = $TopTrack->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetWeeklyAlbumChart()
	{
		$WeeklyAlbumChart = $this->lastfm->user()->getWeeklyAlbumChart( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyAlbumChart, 'Weekly album chart is not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

		/** @var $Album \Lertify\Lastfm\Api\Data\User\Album */
		foreach ( $WeeklyAlbumChart as $Album )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Album', $Album, 'Weekly chart album is not an instance of \Lertify\Lastfm\Api\Data\User\Album!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album', $Album, 'Weekly chart album is not an instance of \Lertify\Lastfm\Api\Data\Album!' );

			$Artist = $Album->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetWeeklyArtistChart()
	{
		$WeeklyArtistChart = $this->lastfm->user()->getWeeklyArtistChart( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyArtistChart, 'Weekly artist chart is not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\User\Artist */
		foreach ( $WeeklyArtistChart as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Weekly chart artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Weekly chart artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetWeeklyTrackChart()
	{
		$WeeklyTrackChart = $this->lastfm->user()->getWeeklyTrackChart( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyTrackChart, 'Weekly track chart is not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\User\Track */
		foreach ( $WeeklyTrackChart as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Track', $Track, 'Weekly chart track is not an instance of \Lertify\Lastfm\Api\Data\User\Track!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track', $Track, 'Weekly chart track is not an instance of \Lertify\Lastfm\Api\Data\Track!' );

			$Artist = $Track->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\User\Artist!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of \Lertify\Lastfm\Api\Data\Artist!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetWeeklyChartList()
	{
		$WeeklyChartList = $this->lastfm->user()->getWeeklyChartList( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyChartList, 'Weekly chart list is not an instance of \Lertify\Lastfm\Api\Data\ArrayCollection!' );

		/** @var $ChartRow \Lertify\Lastfm\Api\Data\User\Chart */
		foreach ( $WeeklyChartList as $ChartRow )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\User\Chart', $ChartRow, 'Chart row is not an instance of \Lertify\Lastfm\Api\Data\User\Chart!' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Group\Chart', $ChartRow, 'Chart row is not an instance of \Lertify\Lastfm\Api\Data\Group\Chart!' );

			$this->assertInstanceOf( 'DateTime', $ChartRow->getFrom(), 'Chart row date is not an instance of \DateTime!' );
			$this->assertInstanceOf( 'DateTime', $ChartRow->getTo(), 'Chart row date is not an instance of \DateTime!' );
		}
	}

	/**
	 * @return void
	 */
	public function testShout()
	{
		$status = $this->lastfm->user()->shout( 'mreniro', 'Good recent tracks!', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}
}