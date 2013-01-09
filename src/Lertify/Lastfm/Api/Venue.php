<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Util\Util;

class Venue extends AbstractApi
{
	const
		PREFIX = 'venue.';

	/**
	 * @link http://www.last.fm/api/show/venue.getEvents
	 *
	 * @param int $venue
	 * @param bool $festivalsonly
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	public function getEvents( $venue, $festivalsonly = false )
	{
		$params = array(
			'venue'         => $venue,
			'festivalsonly' => $festivalsonly,
		);

		$result       = $this->get( self::PREFIX . 'getEvents', $params );
		$resultEvents = $result['events'];

		if ( ! isset( $resultEvents['event'] ) )
		{
			throw new NotFoundException( 'No events found for this venue!' );
		}

		if ( isset( $resultEvents['event'][0] ) )
		{
			$events = $resultEvents['event'];
		}
		else
		{
			$events = array( $resultEvents['event'] );
		}

		$EventsList = new ArrayCollection();

		foreach ( $events as $eventRow )
		{
			$EventsList->add( $this->fillEvent( $eventRow ) );
		}

		return $EventsList;
	}

	/**
	 * @link http://www.last.fm/api/show/venue.getPastEvents
	 *
	 * @param int $venue
	 * @param bool $festivalsonly
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getPastEvents( $venue, $festivalsonly = false )
	{
		$params = array(
			'venue'         => $venue,
			'festivalsonly' => $festivalsonly,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result       = $self->get( Venue::PREFIX . 'getPastEvents', $params );
			$resultEvents = $result['events'];

			if ( ! isset( $resultEvents['event'] ) )
			{
				throw new NotFoundException( 'No past events found for this venue!' );
			}

			$totalResults = (int) $resultEvents['@attr']['total'];
			$totalPages   = (int) $resultEvents['@attr']['totalPages'];

			$List = new ArrayCollection();

			if ( isset( $resultEvents['event'][0] ) )
			{
				$events = $resultEvents['event'];
			}
			else
			{
				$events = array( $resultEvents['event'] );
			}

			foreach ( $events as $eventRow )
			{
				$List->add( $self->fillEvent( $eventRow ) );
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
	 * @link http://www.last.fm/api/show/venue.search
	 *
	 * @param string $venue
	 * @param string|null $country
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function search( $venue, $country = null )
	{
		$params = array(
			'venue'   => $venue,
			'country' => $country,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result       = $self->get( Venue::PREFIX . 'search', $params );
			$resultVenues = $result['results'];

			if ( ! isset( $resultVenues['venuematches'] ) )
			{
				throw new NotFoundException( 'No matched venues found!' );
			}

			$totalResults = (int) $resultVenues['opensearch:totalResults'];
			$itemsPerPage = (int) $resultVenues['opensearch:itemsPerPage'];

			if ( isset( $resultVenues['venuematches']['venue'][0] ) )
			{
				$venues = $resultVenues['venuematches']['venue'];
			}
			else
			{
				$venues = array( $resultVenues['venuematches']['venue'] );
			}

			$List = new ArrayCollection();

			foreach ( $venues as $venueRow )
			{
				$Venue = new Data\Venue\Venue();

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

				$List->add( $Venue );
			}

			return array(
				'results'       => $List,
				'total_pages'   => ceil( $totalResults / $itemsPerPage ),
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @param array $eventRow
	 * @return Data\Venue\Event
	 */
	public function fillEvent( array $eventRow )
	{
		$Event = new Data\Venue\Event();

		$Event->setId( (int) $eventRow['id'] );
		$Event->setTitle( Util::toSting( $eventRow['title'] ) );

		if ( isset( $resultEvent['artists']['headliner'] ) )
		{
			$Event->setHeadliner( Util::toSting( $eventRow['artists']['headliner'] ) );
		}

		$Artists       = new ArrayCollection();
		$resultArtists = $eventRow['artists'];

		if ( is_array( $resultArtists['artist'] ) )
		{
			$artistList = $resultArtists['artist'];
		}
		else
		{
			$artistList = array( $resultArtists['artist'] );
		}

		foreach ( $artistList as $artistName )
		{
			$Artist = new Data\Venue\Artist();

			$Artist->setName( Util::toSting( $artistName ) );

			$Artists->add( $Artist );
		}

		$Event->setArtists( $Artists );

		$Venue    = new Data\Venue\Venue();
		$venueRow = $eventRow['venue'];

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
		$Event->setStartDate( Util::toSting( $eventRow['startDate'] ) );
		$Event->setDescription( Util::toSting( $eventRow['description'] ) );

		$EventImages = new ArrayCollection();

		foreach ( $eventRow['image'] as $image )
		{
			$EventImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
		}

		$Event->setImages( $EventImages );
		$Event->setAttendance( (int) $eventRow['attendance'] );
		$Event->setReviews( (int) $eventRow['reviews'] );

		if ( isset( $eventRow['tag'] ) )
		{
			$Event->setTag( Util::toSting( $eventRow['tag'] ) );
		}

		$TagsList = new ArrayCollection();

		if ( isset( $eventRow['tags'] ) )
		{
			$resultTags = $eventRow['tags'];

			if ( is_array( $resultTags['tag'] ) )
			{
				$tagList = $resultTags['tag'];
			}
			else
			{
				$tagList = array( $resultTags['tag'] );
			}

			foreach ( $tagList as $tagRow )
			{
				$TagsList->add( Util::toSting( $tagRow ) );
			}
		}

		$Event->setTags( $TagsList );
		$Event->setUrl( Util::toSting( $eventRow['url'] ) );
		$Event->setWebsite( Util::toSting( $eventRow['website'] ) );
		$Event->setCancelled( (int) $eventRow['cancelled'] );

		$Tickets = new ArrayCollection();

		if ( isset( $eventRow['tickets'] ) && is_array( $eventRow['tickets'] ) )
		{
			foreach ( $eventRow['tickets']['ticket'] as $ticketRow )
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
}
