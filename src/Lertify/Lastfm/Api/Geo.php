<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Util\Util;

class Geo extends AbstractApi
{
	const
		PREFIX = 'geo.';

	/**
	 * @link http://www.last.fm/api/show/geo.getEvents
	 *
	 * @param float|null $long
	 * @param float|null $lat
	 * @param string|null $location
	 * @param float|null $distance
	 * @param string|null $tag
	 * @param bool $festivalsonly
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getEvents( $long = null, $lat = null, $location = null, $distance = null, $tag = null, $festivalsonly = false )
	{
		$params = array(
			'long'          => $long,
			'lat'           => $lat,
			'location'      => $location,
			'distance'      => $distance,
			'tag'           => $tag,
			'festivalsonly' => $festivalsonly,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result       = $self->get( Geo::PREFIX . 'getEvents', $params );
			$resultEvents = $result['events'];

			if ( ! isset( $resultEvents['event'] ) )
			{
				throw new NotFoundException( 'No events found for this location!' );
			}

			$totalResults = (int) $resultEvents['@attr']['total'];
			$totalPages   = (int) $resultEvents['@attr']['totalPages'];

			if ( isset( $resultEvents['event'][0] ) )
			{
				$events = $resultEvents['event'];
			}
			else
			{
				$events = array( $resultEvents['event'] );
			}

			$List = new ArrayCollection();

			foreach ( $events as $eventRow )
			{
				$Event = new Data\Event();

				$Event->setId( (int) $eventRow['id'] );
				$Event->setTitle( Util::toSting( $eventRow['title'] ) );

				if ( isset( $eventRow['artists']['headliner'] ) )
				{
					$Event->setHeadliner( Util::toSting( $eventRow['artists']['headliner'] ) );
				}

				$Artists = new ArrayCollection();

				if ( is_array( $eventRow['artists']['artist'] ) )
				{
					$artistList = $eventRow['artists']['artist'];
				}
				else
				{
					$artistList = array( $eventRow['artists']['artist'] );
				}

				foreach ( $artistList as $artistName )
				{
					$Artist = new Data\Artist();

					$Artist->setName( Util::toSting( $artistName ) );

					$Artists->add( $Artist );
				}

				$Event->setArtists( $Artists );

				$Venue    = new Data\Venue();
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

				$TagsList = new ArrayCollection();

				if ( isset( $eventRow['tags'] ) )
				{
					if ( is_array( $eventRow['tags']['tag'] ) )
					{
						$tagList = $eventRow['tags']['tag'];
					}
					else
					{
						$tagList = array( $eventRow['tags']['tag'] );
					}

					foreach ( $tagList as $tagRow )
					{
						$TagsList->add( Util::toSting( $tagRow ) );
					}
				}

				if ( isset( $eventRow['tag'] ) )
				{
					$Event->setTag( Util::toSting( $eventRow['tag'] ) );
				}

				$Event->setTags( $TagsList );
				$Event->setUrl( Util::toSting( $eventRow['url'] ) );
				$Event->setWebsite( Util::toSting( $eventRow['website'] ) );
				$Event->setCancelled( (int) $eventRow['cancelled'] );

				$Tickets = new ArrayCollection();

				if ( is_array( $eventRow['tickets'] ) )
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

				$List->add( $Event );
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
	 * @link http://www.last.fm/api/show/geo.getMetroArtistChart
	 *
	 * @param string $metro
	 * @param string $country
	 * @param int|null $start
	 * @param int|null $end
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getMetroArtistChart( $metro, $country, $start = null, $end = null )
	{
		$params = array(
			'metro'   => $metro,
			'country' => $country,
			'start'   => $start,
			'end'     => $end,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result           = $self->get( Geo::PREFIX . 'getMetroArtistChart', $params );
			$resultTopartists = $result['topartists'];

			if ( ! isset( $resultTopartists['artist'] ) )
			{
				throw new NotFoundException( 'No top artists found for this location!' );
			}

			$totalResults = (int) $resultTopartists['@attr']['total'];
			$totalPages   = (int) $resultTopartists['@attr']['totalPages'];

			if ( isset( $resultTopartists['artist'][0] ) )
			{
				$artists = $resultTopartists['artist'];
			}
			else
			{
				$artists = array( $resultTopartists['artist'] );
			}

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new Data\Geo\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );
				$Artist->setListeners( (int) $artistRow['listeners'] );
				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );
				$Artist->setRank( (int) $artistRow['@attr']['rank'] );

				$ArtistImages = new ArrayCollection();

				foreach ( $artistRow['image'] as $image )
				{
					$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}

				$Artist->setImages( $ArtistImages );

				$List->add( $Artist );
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
	 * @link http://www.last.fm/api/show/geo.getMetroHypeArtistChart
	 *
	 * @param string $metro
	 * @param string $country
	 * @param int|null $start
	 * @param int|null $end
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getMetroHypeArtistChart( $metro, $country, $start = null, $end = null )
	{
		$params = array(
			'metro'   => $metro,
			'country' => $country,
			'start'   => $start,
			'end'     => $end,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result           = $self->get( Geo::PREFIX . 'getMetroHypeArtistChart', $params );
			$resultTopartists = $result['topartists'];

			if ( ! isset( $resultTopartists['artist'] ) )
			{
				throw new NotFoundException( 'No top artists found for this location!' );
			}

			$totalResults = (int) $resultTopartists['@attr']['total'];
			$totalPages   = (int) $resultTopartists['@attr']['totalPages'];

			if ( isset( $resultTopartists['artist'][0] ) )
			{
				$artists = $resultTopartists['artist'];
			}
			else
			{
				$artists = array( $resultTopartists['artist'] );
			}

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new Data\Geo\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );
				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );
				$Artist->setRank( (int) $artistRow['@attr']['rank'] );

				$ArtistImages = new ArrayCollection();

				foreach ( $artistRow['image'] as $image )
				{
					$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}

				$Artist->setImages( $ArtistImages );

				$List->add( $Artist );
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
	 * @link http://www.last.fm/api/show/geo.getMetroHypeTrackChart
	 *
	 * @param string $metro
	 * @param string $country
	 * @param int|null $start
	 * @param int|null $end
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getMetroHypeTrackChart( $metro, $country, $start = null, $end = null )
	{
		$params = array(
			'metro'   => $metro,
			'country' => $country,
			'start'   => $start,
			'end'     => $end,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result          = $self->get( Geo::PREFIX . 'getMetroHypeTrackChart', $params );
			$resultToptracks = $result['toptracks'];

			if ( ! isset( $resultToptracks['track'] ) )
			{
				throw new NotFoundException( 'No top tracks found for this location!' );
			}

			$totalResults = (int) $resultToptracks['@attr']['total'];
			$totalPages   = (int) $resultToptracks['@attr']['totalPages'];

			if ( isset( $resultToptracks['track'][0] ) )
			{
				$tracks = $resultToptracks['track'];
			}
			else
			{
				$tracks = array( $resultToptracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Track = new Data\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setDuration( (int) $trackRow['duration'] );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );
				$Track->setRank( (int) $trackRow['@attr']['rank'] );

				$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );
				$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['#text'] ) );

				$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

				$TrackImages = new ArrayCollection();

				if ( isset( $trackRow['image'] ) )
				{
					foreach ( $trackRow['image'] as $image )
					{
						$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Track->setImages( $TrackImages );

				$List->add( $Track );
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
	 * @link http://www.last.fm/api/show/geo.getMetroTrackChart
	 *
	 * @param string $metro
	 * @param string $country
	 * @param int|null $start
	 * @param int|null $end
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getMetroTrackChart( $metro, $country, $start = null, $end = null )
	{
		$params = array(
			'metro'   => $metro,
			'country' => $country,
			'start'   => $start,
			'end'     => $end,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result          = $self->get( Geo::PREFIX . 'getMetroTrackChart', $params );
			$resultToptracks = $result['toptracks'];

			if ( ! isset( $resultToptracks['track'] ) )
			{
				throw new NotFoundException( 'No top tracks found for this location!' );
			}

			$totalResults = (int) $resultToptracks['@attr']['total'];
			$totalPages   = (int) $resultToptracks['@attr']['totalPages'];

			if ( isset( $resultToptracks['track'][0] ) )
			{
				$tracks = $resultToptracks['track'];
			}
			else
			{
				$tracks = array( $resultToptracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Track = new Data\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setDuration( (int) $trackRow['duration'] );
				$Track->setListeners( (int) $trackRow['listeners'] );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );

				$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );
				$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['fulltrack'] ) );

				$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

				$TrackImages = new ArrayCollection();

				if ( isset( $trackRow['image'] ) )
				{
					foreach ( $trackRow['image'] as $image )
					{
						$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Track->setImages( $TrackImages );

				$List->add( $Track );
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
	 * @link http://www.last.fm/api/show/geo.getMetroUniqueArtistChart
	 *
	 * @param string $metro
	 * @param string $country
	 * @param int|null $start
	 * @param int|null $end
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getMetroUniqueArtistChart( $metro, $country, $start = null, $end = null )
	{
		$params = array(
			'metro'   => $metro,
			'country' => $country,
			'start'   => $start,
			'end'     => $end,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result           = $self->get( Geo::PREFIX . 'getMetroUniqueArtistChart', $params );
			$resultTopartists = $result['topartists'];

			if ( ! isset( $resultTopartists['artist'] ) )
			{
				throw new NotFoundException( 'No top artists found for this location!' );
			}

			$totalResults = (int) $resultTopartists['@attr']['total'];
			$totalPages   = (int) $resultTopartists['@attr']['totalPages'];

			if ( isset( $resultTopartists['artist'][0] ) )
			{
				$artists = $resultTopartists['artist'];
			}
			else
			{
				$artists = array( $resultTopartists['artist'] );
			}

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new Data\Geo\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );
				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );
				$Artist->setRank( (int) $artistRow['@attr']['rank'] );

				$ArtistImages = new ArrayCollection();

				foreach ( $artistRow['image'] as $image )
				{
					$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}

				$Artist->setImages( $ArtistImages );

				$List->add( $Artist );
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
	 * @link http://www.last.fm/api/show/geo.getMetroUniqueTrackChart
	 *
	 * @param string $metro
	 * @param string $country
	 * @param int|null $start
	 * @param int|null $end
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getMetroUniqueTrackChart( $metro, $country, $start = null, $end = null )
	{
		$params = array(
			'metro'   => $metro,
			'country' => $country,
			'start'   => $start,
			'end'     => $end,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result          = $self->get( Geo::PREFIX . 'getMetroUniqueTrackChart', $params );
			$resultToptracks = $result['toptracks'];

			if ( ! isset( $resultToptracks['track'] ) )
			{
				throw new NotFoundException( 'No top tracks found for this location!' );
			}

			$totalResults = (int) $resultToptracks['@attr']['total'];
			$totalPages   = (int) $resultToptracks['@attr']['totalPages'];

			if ( isset( $resultToptracks['track'][0] ) )
			{
				$tracks = $resultToptracks['track'];
			}
			else
			{
				$tracks = array( $resultToptracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Track = new Data\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setDuration( (int) $trackRow['duration'] );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );

				$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );
				$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['fulltrack'] ) );

				$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

				$TrackImages = new ArrayCollection();

				if ( isset( $trackRow['image'] ) )
				{
					foreach ( $trackRow['image'] as $image )
					{
						$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Track->setImages( $TrackImages );

				$List->add( $Track );
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
	 * @link http://www.last.fm/api/show/geo.getMetroWeeklyChartlist
	 *
	 * @param $metro
	 * @return ArrayCollection
	 */
	public function getMetroWeeklyChartlist( $metro )
	{
		// @todo Can't implement at the moment, due to missing viable detail description
	}

	/**
	 * @link http://www.last.fm/api/show/geo.getMetros
	 *
	 * @param string|null $country
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	public function getMetros( $country = null )
	{
		$params = array(
			'country' => $country,
		);

		$result       = $this->get( Geo::PREFIX . 'getMetros', $params );
		$resultMetros = $result['metros'];

		if ( ! isset( $resultMetros['metro'] ) )
		{
			throw new NotFoundException( 'No metros found!' );
		}

		if ( isset( $resultMetros['metro'][0] ) )
		{
			$metros = $resultMetros['metro'];
		}
		else
		{
			$metros = array( $resultMetros['metro'] );
		}

		$MetrosList = new ArrayCollection();

		foreach ( $metros as $metroRow )
		{
			$Metro = new Data\Geo\Metro();

			$Metro->setName( Util::toSting( $metroRow['name'] ) );
			$Metro->setCountry( Util::toSting( $metroRow['country'] ) );

			$MetrosList->add( $Metro );
		}

		return $MetrosList;
	}

	/**
	 * @link http://www.last.fm/api/show/geo.getTopArtists
	 *
	 * @param string $country
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getTopArtists( $country )
	{
		$params = array(
			'country' => $country,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result           = $self->get( Geo::PREFIX . 'getTopArtists', $params );
			$resultTopartists = $result['topartists'];

			if ( ! isset( $resultTopartists['artist'] ) )
			{
				throw new NotFoundException( 'No top artists found for this location!' );
			}

			$totalResults = (int) $resultTopartists['@attr']['total'];
			$totalPages   = (int) $resultTopartists['@attr']['totalPages'];

			if ( isset( $resultTopartists['artist'][0] ) )
			{
				$artists = $resultTopartists['artist'];
			}
			else
			{
				$artists = array( $resultTopartists['artist'] );
			}

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new Data\Geo\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );
				$Artist->setListeners( (int) $artistRow['listeners'] );
				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );
				$Artist->setRank( (int) $artistRow['@attr']['rank'] );

				$ArtistImages = new ArrayCollection();

				if ( isset( $artistRow['image'] ) )
				{
					foreach ( $artistRow['image'] as $image )
					{
						$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Artist->setImages( $ArtistImages );

				$List->add( $Artist );
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
	 * @link http://www.last.fm/api/show/geo.getTopTracks
	 *
	 * @param string $country
	 * @param string|null $location
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getTopTracks( $country, $location = null )
	{
		$params = array(
			'country'  => $country,
			'location' => $location,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result          = $self->get( Geo::PREFIX . 'getTopTracks', $params );
			$resultToptracks = $result['toptracks'];

			if ( ! isset( $resultToptracks['track'] ) )
			{
				throw new NotFoundException( 'No top tracks found for this location!' );
			}

			$totalResults = (int) $resultToptracks['@attr']['total'];
			$totalPages   = (int) $resultToptracks['@attr']['totalPages'];

			if ( isset( $resultToptracks['track'][0] ) )
			{
				$tracks = $resultToptracks['track'];
			}
			else
			{
				$tracks = array( $resultToptracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Track = new Data\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setDuration( (int) $trackRow['duration'] );
				$Track->setListeners( (int) $trackRow['listeners'] );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );
				$Track->setRank( (int) $trackRow['@attr']['rank'] );

				$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );
				$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['fulltrack'] ) );

				$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

				$TrackImages = new ArrayCollection();

				if ( isset( $trackRow['image'] ) )
				{
					foreach ( $trackRow['image'] as $image )
					{
						$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Track->setImages( $TrackImages );

				$List->add( $Track );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}
}
