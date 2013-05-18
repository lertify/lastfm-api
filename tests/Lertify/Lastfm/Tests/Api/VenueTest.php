<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class VenueTest extends Setup
{
	public function testGetEvents()
	{
		$Events = $this->lastfm->venue()->getEvents( 8908030 );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Events, 'Events are not an instance of Data\ArrayCollection!' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Venue\Event */
		foreach ( $Events as $Event )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue\Event', $Event, 'Event is not an instance of Data\Venue\Event!' );

			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of Data\ArrayCollection!' );

			foreach ( $Artists as $Artist )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue\Artist', $Artist, 'Artist is not an instance of Data\Venue\Artist!' );
			}

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue\Venue', $Venue, 'Venue is not an instance of Data\Venue\Venue!' );

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

	public function testGetPastEvents()
	{
		$Events = $this->lastfm->venue()->getPastEvents( 8908030 );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Events, 'Events are not an instance of PagedCollection!' );

		/** @var $Event \Lertify\Lastfm\Api\Data\Venue\Event */
		foreach ( $Events->getPage( 1 ) as $Event )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue\Event', $Event, 'Event is not an instance of Data\Venue\Event!' );

			$Artists = $Event->getArtists();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of Data\ArrayCollection!' );

			foreach ( $Artists as $Artist )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue\Artist', $Artist, 'Artist is not an instance of Data\Venue\Artist!' );
			}

			$Venue = $Event->getVenue();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue\Venue', $Venue, 'Venue is not an instance of Data\Venue\Venue!' );

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

	public function testSearch()
	{
		$Venues = $this->lastfm->venue()->search( 'arena', 'ee' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Venues, 'Venues are not an instance of PagedCollection!' );

		/** @var $Venue \Lertify\Lastfm\Api\Data\Venue\Venue */
		foreach ( $Venues->getPage( 1 ) as $Venue )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Venue\Venue', $Venue, 'Venue is not an instance of Data\Venue\Venue!' );

			$VenueImages = $Venue->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $VenueImages, 'VenueImages are not an instance of Data\ArrayCollection!' );
		}
	}
}
