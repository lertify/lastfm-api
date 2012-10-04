<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api;

use InvalidArgumentException,
	Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Api\Data\Event\User,
	Lertify\Lastfm\Util\Util;

class Event extends AbstractApi
{
	const
		PREFIX = 'event.';

	const
		EVENT_STATUS_ATTENDING       = 0,
		EVENT_STATUS_MAYBE_ATTENDING = 1,
		EVENT_STATUS_NOT_ATTENDING   = 2;

	/**
	 * @link http://www.last.fm/api/show/event.attend
	 *
	 * @param int $eventId
	 * @param int $status
	 * @param string $sk
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function attend( $eventId, $status, $sk )
	{
		if ( ! $this->validateEventStatus( $status ) )
		{
			throw new InvalidArgumentException( 'Invalid status was supplied!' );
		}

		$params = array(
			'event'  => $eventId,
			'status' => $status,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'attend', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/event.getAttendees
	 *
	 * @param int $eventId
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getAttendees( $eventId )
	{
		$params = array(
			'event' => $eventId,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result          = $self->get( Event::PREFIX . 'getAttendees', $params );
			$resultAttendees = $result['attendees'];

			if ( ! isset( $resultAttendees['user'] ) )
			{
				throw new NotFoundException( 'No attendees found for this event!' );
			}

			$totalResults = (int) $resultAttendees['@attr']['total'];
			$totalPages   = (int) $resultAttendees['@attr']['totalPages'];

			$List = new ArrayCollection();

			if ( isset( $resultAttendees['user'][0] ) )
			{
				$attendees = $resultAttendees['user'];
			}
			else
			{
				$attendees = array( $resultAttendees['user'] );
			}

			foreach ( $attendees as $userRow )
			{
				$User = new User();

				$User->setName( Util::toSting( $userRow['name'] ) );
				$User->setRealName( Util::toSting( $userRow['realname'] ) );
				$User->setUrl( Util::toSting( $userRow['url'] ) );

				$UserImages = new ArrayCollection();

				foreach ( $userRow['image'] as $image )
				{
					$UserImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}

				$User->setImages( $UserImages );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/event.getInfo
	 *
	 * @param int $eventId
	 * @return Data\Event\Event
	 */
	public function getInfo( $eventId )
	{
		$params = array(
			'event' => $eventId,
		);

		$result      = $this->get( self::PREFIX . 'getInfo', $params );
		$resultEvent = $result['event'];

		$Event = new Data\Event\Event();

		$Event->setId( (int) $resultEvent['id'] );
		$Event->setTitle( Util::toSting( $resultEvent['title'] ) );

		if ( isset( $resultEvent['artists']['headliner'] ) )
		{
			$Event->setHeadliner( Util::toSting( $resultEvent['artists']['headliner'] ) );
		}

		$Artists = new ArrayCollection();

		if ( is_array( $resultEvent['artists']['artist'] ) )
		{
			$artistList = $resultEvent['artists']['artist'];
		}
		else
		{
			$artistList = array( $resultEvent['artists']['artist'] );
		}

		foreach ( $artistList as $artistName )
		{
			$Artist = new Data\Artist();

			$Artist->setName( Util::toSting( $artistName ) );

			$Artists->add( $Artist );
		}

		$Event->setArtists( $Artists );

		$Venue    = new Data\Event\Venue();
		$venueRow = $resultEvent['venue'];

		$Venue->setId( (int) $venueRow['id'] );
		$Venue->setName( Util::toSting( $venueRow['name'] ) );
		$Venue->setCity( Util::toSting( $venueRow['location']['city'] ) );
		$Venue->setCountry( Util::toSting( $venueRow['location']['country'] ) );
		$Venue->setStreet( Util::toSting( $venueRow['location']['street'] ) );
		$Venue->setPostalcode( (int) $venueRow['location']['postalcode'] );
		$Venue->setLatitude( (float) $venueRow['location']['geo:point']['geo:lat'] );
		$Venue->setLongitude( (float) $venueRow['location']['geo:point']['geo:long'] );
		$Venue->setUrl( Util::toSting( $venueRow['url'] ) );
		$Venue->setWebsite( Util::toSting( $venueRow['website'] ) );
		$Venue->setPhonenumber( Util::toSting( $venueRow['phonenumber'] ) );

		$VenueImages = new ArrayCollection();

		foreach ( $venueRow['image'] as $venueRowImage )
		{
			$VenueImages->set( Util::toSting( $venueRowImage['size'] ), Util::toSting( $venueRowImage['#text'] ) );
		}

		$Venue->setImages( $VenueImages );

		$Event->setVenue( $Venue );
		$Event->setStartDate( Util::toSting( $resultEvent['startDate'] ) );
		$Event->setDescription( Util::toSting( $resultEvent['description'] ) );

		$EventImages = new ArrayCollection();

		foreach ( $resultEvent['image'] as $image )
		{
			$EventImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
		}

		$Event->setImages( $EventImages );
		$Event->setAttendance( (int) $resultEvent['attendance'] );
		$Event->setReviews( (int) $resultEvent['reviews'] );

		$TagsList = new ArrayCollection();

		if ( isset( $resultEvent['tags'] ) )
		{
			if ( is_array( $resultEvent['tags']['tag'] ) )
			{
				$tagList = $resultEvent['tags']['tag'];
			}
			else
			{
				$tagList = array( $resultEvent['tags']['tag'] );
			}

			foreach ( $tagList as $tagRow )
			{
				$TagsList->add( Util::toSting( $tagRow ) );
			}
		}

		if ( isset( $resultEvent['tag'] ) )
		{
			$Event->setTag( Util::toSting( $resultEvent['tag'] ) );
		}

		$Event->setTags( $TagsList );
		$Event->setUrl( Util::toSting( $resultEvent['url'] ) );
		$Event->setWebsite( Util::toSting( $resultEvent['website'] ) );
		$Event->setCancelled( (int) $resultEvent['cancelled'] );

		$Tickets = new ArrayCollection();

		if ( is_array( $resultEvent['tickets'] ) )
		{
			foreach ( $resultEvent['tickets']['ticket'] as $ticketRow )
			{
				$Tickets->add( array(
					'supplier' => Util::toSting( $ticketRow['supplier'] ),
					'url'      => Util::toSting( $ticketRow['#text'] ),
				) );
			}
		}

		$Event->setTickets( $Tickets );

		return $Event;
	}

	/**
	 * @link http://www.last.fm/api/show/event.getShouts
	 *
	 * @param int $eventId
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getShouts( $eventId )
	{
		$params = array(
			'event' => $eventId,
		);

		$self = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Event */
			$result       = $self->get( Event::PREFIX . 'getShouts', $params );
			$resultShouts = $result['shouts'];

			if ( ! isset( $resultShouts['shout'] ) )
			{
				throw new NotFoundException( 'No shouts found for this event!' );
			}

			$totalResults = (int) $resultShouts['@attr']['total'];
			$totalPages   = (int) $resultShouts['@attr']['totalPages'];

			if ( isset( $resultShouts['shout'][0] ) )
			{
				$shouts = $resultShouts['shout'];
			}
			else
			{
				$shouts = array( $resultShouts['shout'] );
			}

			$List = new ArrayCollection();

			foreach ( $shouts as $shoutRow )
			{
				$Shout = new Data\Shout();

				$Shout->setAuthor( Util::toSting( $shoutRow['author'] ) );
				$Shout->setBody( Util::toSting( $shoutRow['body'] ) );
				$Shout->setDate( Util::toSting( $shoutRow['date'] ) );

				$List->add( $Shout );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/event.share
	 *
	 * @param int $eventId
	 * @param string|array $recipient
	 * @param string $sk
	 * @param bool $public
	 * @param string|null $message
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function share( $eventId, $recipient, $sk, $public = false, $message = null )
	{
		if ( is_array( $recipient ) )
		{
			if ( count( $recipient ) > 10 )
			{
				throw new InvalidArgumentException( 'The allowed maximum is 10 recipients per request' );
			}

			$recipient = implode( ',', $recipient );
		}

		$params = array(
			'event'     => $eventId,
			'recipient' => $recipient,
			'sk'        => $sk,
			'public'    => (int) $public,
		);

		if ( null !== $message )
		{
			$params['message'] = $message;
		}

		$result = $this->post( self::PREFIX . 'share', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/event.shout
	 *
	 * @param int $eventId
	 * @param string $message
	 * @param string $sk
	 * @return string
	 */
	public function shout( $eventId, $message, $sk )
	{
		$params = array(
			'event'   => $eventId,
			'message' => $message,
			'sk'      => $sk,
		);

		$result = $this->post( self::PREFIX . 'shout', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @param int $statusId
	 * @return bool
	 */
	private function validateEventStatus( $statusId )
	{
		$map = array(
			self::EVENT_STATUS_ATTENDING,
			self::EVENT_STATUS_MAYBE_ATTENDING,
			self::EVENT_STATUS_NOT_ATTENDING,
		);

		return isset( $map[ $statusId ] );
	}
}
