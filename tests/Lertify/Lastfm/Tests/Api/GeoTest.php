<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class GeoTest extends Setup
{
	public function testGetEvents()
	{
		$Events = $this->lastfm->geo()->getEvents();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Events, 'Events are not an instance of PagedCollection!' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Event */
		foreach ( $Events->getPage( 1 ) as $Event )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Event', $Event, 'Event is not an instance of Data\Event!' );

			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of Data\ArrayCollection!' );

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue', $Venue, 'Venue is not an instance of Data\Venue!' );

			$VenueImages = $Venue->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $VenueImages, 'VenueImages are not an instance of Data\ArrayCollection!' );

			$EventImages = $Event->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $EventImages, 'EventImages are not an instance of Data\ArrayCollection!' );

			$Tags = $Event->getTags();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags are not an instance of Data\ArrayCollection!' );

			$Tickets = $Event->getTickets();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tickets, 'Tickets are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetMetroArtistChart()
	{
		$Artists = $this->lastfm->geo()->getMetroArtistChart( 'madrid', 'spain' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Artists are not an instance of PagedCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Geo\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Geo\Artist', $Artist, 'Artist is not an instance of Data\Geo\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetMetroHypeArtistChart()
	{
		$Artists = $this->lastfm->geo()->getMetroHypeArtistChart( 'madrid', 'spain' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Artists are not an instance of PagedCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Geo\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Geo\Artist', $Artist, 'Artist is not an instance of Data\Geo\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetMetroHypeTrackChart()
	{
		$Tracks = $this->lastfm->geo()->getMetroHypeTrackChart( 'madrid', 'spain' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track', $Track, 'Track is not an instance of Data\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetMetroTrackChart()
	{
		$Tracks = $this->lastfm->geo()->getMetroTrackChart( 'madrid', 'spain' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track', $Track, 'Track is not an instance of Data\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetMetroUniqueArtistChart()
	{
		$Artists = $this->lastfm->geo()->getMetroUniqueArtistChart( 'madrid', 'spain' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Artists are not an instance of PagedCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Geo\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Geo\Artist', $Artist, 'Artist is not an instance of Data\Geo\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetMetroUniqueTrackChart()
	{
		$Tracks = $this->lastfm->geo()->getMetroUniqueTrackChart( 'madrid', 'spain' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track', $Track, 'Track is not an instance of Data\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetMetroWeeklyChartlist()
	{
		// @todo Can't implement at the moment, due to missing viable detail description
	}

	public function testGetMetros()
	{
		$Metros = $this->lastfm->geo()->getMetros();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Metros, 'Metros are not an instance of Data\ArrayCollection!' );

		/** @var $Metro \Lertify\Lastfm\Api\Data\Geo\Metro */
		foreach ( $Metros as $Metro )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Geo\Metro', $Metro, 'Metro is not an instance of Data\Geo\Metro!' );
		}
	}

	public function testGetTopArtists()
	{
		$TopArtists = $this->lastfm->geo()->getTopArtists( 'Spain' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopArtists, 'TopArtists are not an instance of PagedCollection!' );

		/** @var $TopArtist \Lertify\Lastfm\Api\Data\Geo\Artist */
		foreach ( $TopArtists->getPage( 1 ) as $TopArtist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Geo\Artist', $TopArtist, 'TopArtist is not an instance of Data\Geo\Artist!' );

			$TopArtistImages = $TopArtist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopArtistImages, 'TopArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetTopTracks()
	{
		$TopTracks = $this->lastfm->geo()->getTopTracks( 'Spain' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopTracks, 'TopTracks are not an instance of PagedCollection!' );

		/** @var $TopTrack \Lertify\Lastfm\Api\Data\Track */
		foreach ( $TopTracks->getPage( 1 ) as $TopTrack )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track', $TopTrack, 'TopTrack is not an instance of Data\Track!' );

			$TrackImages = $TopTrack->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}
}
