<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data,
	Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Api\Data\Artist\Event,
	Lertify\Lastfm\Api\Data\Artist\Venue,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Util\Util,
	InvalidArgumentException;

class Artist extends AbstractApi
{
	const
		PREFIX = 'artist.';

	/**
	 * @link http://www.last.fm/api/show/artist.addTags
	 *
	 * @param string $artist
	 * @param array $tags
	 * @param string $sk
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function addTags( $artist, array $tags, $sk )
	{
		if ( count( $tags ) > 10 )
		{
			throw new InvalidArgumentException( 'The allowed maximum is 10 tags per request' );
		}

		$params = array(
			'artist' => $artist,
			'tags'   => implode( ',', $tags ),
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'addTags', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getCorrection
	 *
	 * @param string $artist
	 * @throws NotFoundException
	 * @return Data\Artist\Artist
	 */
	public function getCorrection( $artist )
	{
		$params = array(
			'artist' => $artist,
		);

		$result           = $this->get( self::PREFIX . 'getCorrection', $params );
		$resultCorrection = $result['corrections'];

		if ( ! is_array( $resultCorrection ) )
		{
			throw new NotFoundException( 'No artist found!' );
		}

        $Artist           = new Data\Artist\Artist();
		$artistCorrection = $resultCorrection['correction']['artist'];

		$Artist->setName( Util::toSting( $artistCorrection['name'] ) );
		$Artist->setMbid( Util::toSting( $artistCorrection['mbid'] ) );
		$Artist->setUrl( Util::toSting( $artistCorrection['url'] ) );

		return $Artist;
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getEvents
	 *
	 * @param string $artist
	 * @param bool $autocorrect
	 * @param bool $festivalsonly
	 * @return PagedCollection
	 */
	public function getEvents( $artist, $autocorrect = false, $festivalsonly = false )
	{
		$params = array(
			'artist'        => $artist,
			'autocorrect'   => $autocorrect,
			'festivalsonly' => $festivalsonly,
		);

		return $this->fetchEvents( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getEvents
	 *
	 * @param string $mbid
	 * @param bool $festivalsonly
	 * @return PagedCollection
	 */
	public function getEventsByMbid( $mbid, $festivalsonly = false )
	{
		$params = array(
			'mbid'          => $mbid,
			'festivalsonly' => $festivalsonly,
		);

		return $this->fetchEvents( $params );
	}

	/**
	 * @param string $artist
	 * @param bool $autocorrect
	 * @param string|null $lang      ISO 639 alpha-2 code
	 * @param string|null $username  If supplied, the user's playcount for this artist is included in the response.
	 * @return Data\Artist\Artist
	 */
	public function getInfo( $artist, $autocorrect = false, $lang = null, $username = null )
	{
		$params = array(
			'artist'      => $artist,
			'autocorrect' => $autocorrect,
			'lang'        => $lang,
			'username'    => $username,
		);

		return $this->fetchInfo( $params );
	}

	/**
	 * @param string $mbid
	 * @param string|null $lang       ISO 639 alpha-2 code
	 * @param string|null $username   If supplied, the user's playcount for this artist is included in the response.
	 * @return Data\Artist\Artist
	 */
	public function getInfoByMbid( $mbid, $lang = null, $username = null )
	{
		$params = array(
			'mbid'     => $mbid,
			'lang'     => $lang,
			'username' => $username,
		);

		return $this->fetchInfo( $params );
	}

	/**
	 * @param string $artist
	 * @param bool $autocorrect
	 * @return PagedCollection
	 */
	public function getPastEvents( $artist, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchPastEvents( $params );
	}

	/**
	 * @param string $mbid
	 * @return PagedCollection
	 */
	public function getPastEventsByMbid( $mbid )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchPastEvents( $params );
	}

	/**
	 * @param string $artist
	 * @param bool $autocorrect
	 */
	public function getPodcast( $artist, $autocorrect = false )
	{
		// @todo Can't implement at the moment, due to missing viable working example
	}

	/**
	 * @param string $mbid
	 */
	public function getPodcastByMbid( $mbid )
	{
		// @todo Can't implement at the moment, due to missing viable working example
	}

	/**
	 * @param string $artist
	 * @param bool $autocorrect
	 * @return PagedCollection
	 */
	public function getShouts( $artist, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchShouts( $params );
	}

	/**
	 * @param string $mbid
	 * @return PagedCollection
	 */
	public function getShoutsByMbid( $mbid )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchShouts( $params );
	}

	/**
	 * @param string $artist
	 * @param bool $autocorrect
	 * @param int|null $limit
	 * @return Data\Artist\Artist
	 */
	public function getSimilar( $artist, $autocorrect = false, $limit = null )
	{
		$params = array(
			'artist'      => $artist,
			'autocorrect' => $autocorrect,
			'limit'       => $limit,
		);

		return $this->fetchSimilar( $params );
	}

	/**
	 * @param string $mbid
	 * @param int|null $limit
	 * @return Data\Artist\Artist
	 */
	public function getSimilarByMbid( $mbid, $limit = null )
	{
		$params = array(
			'mbid'  => $mbid,
			'limit' => $limit,
		);

		return $this->fetchSimilar( $params );
	}

	/**
	 * @param string $artist
	 * @param string $username
	 * @param bool $autocorrect
	 * @return ArrayCollection
	 */
	public function getTags( $artist, $username, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'user'        => $username,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTags( $params );
	}

	/**
	 * @param string $artist
	 * @param string $sk
	 * @param bool $autocorrect
	 * @return ArrayCollection
	 */
	public function getTagsAuth( $artist, $sk, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'sk'          => $sk,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTags( $params, array( 'is_signed' => true ) );
	}

	/**
	 * @param string $mbid
	 * @param string $username
	 * @return ArrayCollection
	 */
	public function getTagsByMbid( $mbid, $username )
	{
		$params = array(
			'mbid' => $mbid,
			'user' => $username,
		);

		return $this->fetchTags( $params );
	}

	/**
	 * @param string $mbid
	 * @param string $sk
	 * @return ArrayCollection
	 */
	public function getTagsByMbidAuth( $mbid, $sk )
	{
		$params = array(
			'mbid' => $mbid,
			'sk'   => $sk,
		);

		return $this->fetchTags( $params, array( 'is_signed' => true ) );
	}

	/**
	 * @param array $params
	 * @param array $options
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	private function fetchTags( array $params, array $options = array() )
	{
		$result     = $this->get( self::PREFIX . 'getTags', $params, $options );
		$resultTags = $result['tags'];

		if ( ! isset( $resultTags['tag'] ) )
		{
			throw new NotFoundException( 'No tags were found for this artist!' );
		}

		if ( isset( $resultTags['tag'][0] ) )
		{
			$tags = $resultTags['tag'];
		}
		else
		{
			$tags = array( $resultTags['tag'] );
		}

		$TagsList = new ArrayCollection();

		foreach ( $tags as $tagRow )
		{
			$Tag = new Data\Artist\Tag();

			$Tag->setName( Util::toSting( $tagRow['name'] ) );
			$Tag->setUrl( Util::toSting( $tagRow['url'] ) );

			$TagsList->add( $Tag );
		}

		return $TagsList;
	}

	/**
	 * @param array $params
	 * @return Data\Artist\Artist
	 */
	private function fetchSimilar( array $params )
	{
		$result               = $this->get( self::PREFIX . 'getSimilar', $params );
		$resultSimilarArtists = $result['similarartists'];

		$SimilarArtists = new ArrayCollection();

		foreach ( $resultSimilarArtists['artist'] as $artistRow )
		{
			$Artist = new Data\Artist\Artist();

			$Artist->setName( Util::toSting( $artistRow['name'] ) );
			$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
			$Artist->setMatch( (float) $artistRow['match'] );
			$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
			$Artist->setStreamable( (int) $artistRow['streamable'] );

			$ArtistImages = new ArrayCollection();

			foreach ( $artistRow['image'] as $image )
			{
				$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
			}

			$Artist->setImages( $ArtistImages );
			$SimilarArtists->add( $Artist );
		}

		$MainArtist = new Data\Artist\Artist();

		$MainArtist->setName( Util::toSting( $resultSimilarArtists['@attr']['artist'] ) );
		$MainArtist->setSimilar( $SimilarArtists );

		return $MainArtist;
	}

	/**
	 * @param array $params
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	private function fetchShouts( array $params )
	{
		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Artist */
			$result       = $self->get( Artist::PREFIX . 'getShouts', $params );
			$resultShouts = $result['shouts'];

			if ( ! isset( $resultShouts['shout'] ) )
			{
				throw new NotFoundException( 'No shouts found for this artist!' );
			}

			$totalResults = (int) $resultShouts['@attr']['total'];
			$totalPages   = (int) $resultShouts['@attr']['totalPages'];

			$List = new ArrayCollection();

			if ( isset( $resultShouts['shout'][0] ) )
			{
				$shouts = $resultShouts['shout'];
			}
			else
			{
				$shouts = array( $resultShouts['shout'] );
			}

			foreach ( $shouts as $shoutRow )
			{
				$Shout = new Data\Artist\Shout();

				$Shout->setArtist( Util::toSting( $resultShouts['@attr']['artist'] ) );
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
	 * @param array $params
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	private function fetchPastEvents( array $params )
	{
		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Artist */
			$result       = $self->get( Artist::PREFIX . 'getPastEvents', $params );
			$resultEvents = $result['events'];

			if ( ! isset( $resultEvents['event'] ) )
			{
				throw new NotFoundException( 'No events found for this artist!' );
			}

			$totalResults = (int) $resultEvents['@attr']['total'];
			$totalPages   = (int) $resultEvents['@attr']['totalPages'];

			$List = new ArrayCollection();

			foreach ( $resultEvents['event'] as $eventRow )
			{
				$Event = new Event();

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
					$Artist = new Data\Artist\Artist();

					$Artist->setName( Util::toSting( $artistName ) );

					$Artists->add( $Artist );
				}

				$Event->setArtists( $Artists );

				$Venue    = new Venue();
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

				foreach ( $eventRow['image'] as $eventImage )
				{
					$EventImages->set( Util::toSting( $eventImage['size'] ), Util::toSting( $eventImage['#text'] ) );
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
	 * @param array $params
	 * @return Data\Artist\Artist
	 */
	private function fetchInfo( array $params )
	{
		$result       = $this->get( Artist::PREFIX . 'getInfo', $params );
		$resultArtist = $result['artist'];

		$Artist = new Data\Artist\Artist();

		$Artist->setName( Util::toSting( $resultArtist['name'] ) );
		$Artist->setMbid( Util::toSting( $resultArtist['mbid'] ) );
		$Artist->setUrl( Util::toSting( $resultArtist['url'] ) );

		$ArtistImages = new ArrayCollection();

		foreach ( $resultArtist['image'] as $image )
		{
			$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
		}

		$Artist->setImages( $ArtistImages );
		$Artist->setStreamable( (bool) $resultArtist['streamable'] );

		$Artist->setListeners( (int) $resultArtist['stats']['listeners'] );
		$Artist->setPlaycount( (int) $resultArtist['stats']['playcount'] );

		if ( isset( $resultArtist['stats']['listeners'] ) )
		{
			$Artist->setUserplaycount( (int) $resultArtist['stats']['listeners'] );
		}

		$SimilarArtists = new ArrayCollection();

		foreach ( $resultArtist['similar']['artist'] as $similarArtistRow )
		{
			$SimilarArtist = new Data\Artist\Artist();

			$SimilarArtist->setName( Util::toSting( $similarArtistRow['name'] ) );
			$SimilarArtist->setUrl( Util::toSting( $similarArtistRow['url'] ) );

			$SimilarArtistImages = new ArrayCollection();

			foreach ( $similarArtistRow['image'] as $image )
			{
				$SimilarArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
			}

			$SimilarArtist->setImages( $SimilarArtistImages );
			$SimilarArtists->add( $SimilarArtist );
		}

		$Artist->setSimilar( $SimilarArtists );

		$Tags = new ArrayCollection();

		foreach ( $resultArtist['tags']['tag'] as $tagRow )
		{
			$Tag = new Data\Artist\Tag();

			$Tag->setName( Util::toSting( $tagRow['name'] ) );
			$Tag->setUrl( Util::toSting( $tagRow['url'] ) );

			$Tags->add( $Tag );
		}

		$Artist->setTags( $Tags );

		$Artist->setPublished( $resultArtist['bio']['published'] );
		$Artist->setSummary( $resultArtist['bio']['summary'] );
		$Artist->setContent( $resultArtist['bio']['content'] );

		return $Artist;
	}

	/**
	 * @param array $params
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	private function fetchEvents( array $params )
	{
		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Artist */
			$result       = $self->get( Artist::PREFIX . 'getEvents', $params );
			$resultEvents = $result['events'];

			if ( ! isset( $resultEvents['event'] ) )
			{
				throw new NotFoundException( 'No events found for this artist!' );
			}

			$List = new ArrayCollection();

			$totalResults = (int) $resultEvents['@attr']['total'];
			$totalPages   = (int) $resultEvents['@attr']['totalPages'];

			foreach ( $resultEvents['event'] as $eventRow )
			{
				$Event = new Event();

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
					$Artist = new Data\Artist\Artist();

					$Artist->setName( Util::toSting( $artistName ) );

					$Artists->add( $Artist );
				}

				$Event->setArtists( $Artists );

				$Venue    = new Venue();
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

				foreach ( $eventRow['image'] as $eventImage )
				{
					$EventImages->set( Util::toSting( $eventImage['size'] ), Util::toSting( $eventImage['#text'] ) );
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
}
