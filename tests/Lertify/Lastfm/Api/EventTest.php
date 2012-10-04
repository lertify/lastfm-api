<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Tests\Api;

class EventTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testAttend()
	{
		$status = $this->lastfm->event()->attend( 3354362, \Lertify\Lastfm\Api\Event::EVENT_STATUS_MAYBE_ATTENDING, $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testGetAttendees()
	{
		$Attendees = $this->lastfm->event()->getAttendees( 3354362 );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Attendees, 'Attendees are not an instance of PagedCollection!' );

		/** @var $User \Lertify\Lastfm\Api\Data\Event\User */
		foreach ( $Attendees->getPage( 1 ) as $User )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Event\User', $User, 'User is not an instance of Data\Event\User!' );

			$UserImages = $User->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $UserImages, 'UserImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetInfo()
	{
		$Event = $this->lastfm->event()->getInfo( 3354362 );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Event\Event', $Event, 'Event is not an instance of Data\Event\Event!' );

		$Artists = $Event->getArtists();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Artists, 'Artists are not an instance of Data\ArrayCollection!' );

		foreach ( $Artists as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Artist', $Artist, 'Artist is not an instance of Data\Artist!' );
		}

		$Venue = $Event->getVenue();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Event\Venue', $Venue, 'Venue is not an instance of Data\Event\Venue!' );

		$VenueImages = $Venue->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $VenueImages, 'VenueImages are not an instance of Data\ArrayCollection!' );

		$EventImages = $Event->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $EventImages, 'EventImages are not an instance of Data\ArrayCollection!' );

		$Tags = $Event->getTags();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags are not an instance of Data\ArrayCollection!' );

		$Tickets = $Event->getTickets();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tickets, 'Tickets are not an instance of Data\ArrayCollection!' );
	}

	public function testGetShouts()
	{
		$Shouts = $this->lastfm->event()->getShouts( 3354362 );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Shouts, 'Shouts are not an instance of PagedCollection!' );

		foreach ( $Shouts->getPage( 1 ) as $Shout )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Shout', $Shout, 'Shout is not an instance of Data\Shout!' );
		}
	}

	public function testShare()
	{
		$status = $this->lastfm->event()->share( 3354362, $GLOBALS['tests_email'], $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testShout()
	{
		$status = $this->lastfm->event()->shout( 3354362, 'Awesome event', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}
}
