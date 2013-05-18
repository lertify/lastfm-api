<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\User as UserData,
	Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Exception\NotFoundException,

	DateTime;

class User extends AbstractApi
{
	const
		PREFIX = 'user.';

	/**
	 * @link http://www.last.fm/api/show/user.getArtistTracks
	 *
	 * @param string $artist
	 * @param string $user
	 * @param string|null $startTimestamp Unix timestamp
	 * @param string|null $endTimestamp Unix timestamp
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getArtistTracks( $artist, $user, $startTimestamp = null, $endTimestamp = null )
	{
		$params = array(
			'artist'         => $artist,
			'user'           => $user,
			'startTimestamp' => $startTimestamp,
			'endTimestamp'   => $endTimestamp,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params             = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result             = $self->get( User::PREFIX . 'getArtistTracks', $params );
			$resultArtisttracks = $result['artisttracks'];

			if ( ! isset( $resultArtisttracks['track'] ) )
			{
				throw new NotFoundException( 'No tracks for this artist and user!' );
			}

			if ( isset( $resultArtisttracks['track'][0] ) && is_array( $resultArtisttracks['track'][0] ) )
			{
				$tracks = $resultArtisttracks['track'];
			}
			else
			{
				$tracks = array( $resultArtisttracks['track'] );
			}

			$totalPages = (int) $resultArtisttracks['@attr']['totalPages'];
			$total      = (int) $resultArtisttracks['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $trackRow['artist']['#text'] )
					->setMbid( (string) $trackRow['artist']['mbid'] );

				$Album = new UserData\Album();

				$Album
					->setName( (string) $trackRow['album']['#text'] )
					->setMbid( (string) $trackRow['album']['mbid'] );

				$Track = new UserData\Track();

				$Track
					->setPlayedAt( new DateTime( $trackRow['date']['#text'] ) )
					->setName( (string) $trackRow['name'] )
					->setMbId( (string) $trackRow['mbid'] )
					->setUrl( (string) $trackRow['url'] )
					->setStreamable( (bool) $trackRow['streamable'] )
					->setArtist( $Artist )
					->setAlbum( $Album )
					->setImages( $self->getImageList( $trackRow['image'] ) );

				$List->add( $Track );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getBannedTracks
	 *
	 * @param string $user
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getBannedTracks( $user )
	{
		$params = array(
			'user' => $user,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params             = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result             = $self->get( User::PREFIX . 'getBannedTracks', $params );
			$resultBannedtracks = $result['bannedtracks'];

			if ( ! isset( $resultBannedtracks['track'] ) )
			{
				throw new NotFoundException( 'No banned tracks found for this user!' );
			}

			if ( isset( $resultBannedtracks['track'][0] ) && is_array( $resultBannedtracks['track'][0] ) )
			{
				$tracks = $resultBannedtracks['track'];
			}
			else
			{
				$tracks = array( $resultBannedtracks['track'] );
			}

			$totalPages = (int) $resultBannedtracks['@attr']['totalPages'];
			$total      = (int) $resultBannedtracks['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $trackRow['artist']['name'] )
					->setMbid( (string) $trackRow['artist']['mbid'] )
					->setUrl( (string) $trackRow['artist']['url'] );

				$Track = new UserData\Track();

				$Track
					->setBannedAt( new DateTime( $trackRow['date']['#text'] ) )
					->setName( (string) $trackRow['name'] )
					->setMbId( (string) $trackRow['mbid'] )
					->setUrl( (string) $trackRow['url'] )
					->setStreamable( (bool) $trackRow['streamable']['#text'] )
					->setStreamableFulltrack( (bool) $trackRow['streamable']['fulltrack'] )
					->setArtist( $Artist );

				if ( isset( $trackRow['image'] ) )
				{
					$Track->setImages( $self->getImageList( $trackRow['image'] ) );
				}
				else
				{
					$Track->setImages( new ArrayCollection() );
				}

				$List->add( $Track );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getEvents
	 *
	 * @param string $user
	 * @param bool $festivalsOnly
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getEvents( $user, $festivalsOnly = true )
	{
		$params = array(
			'user'          => $user,
			'festivalsonly' => $festivalsOnly,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params       = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result       = $self->get( User::PREFIX . 'getEvents', $params );
			$resultEvents = $result['events'];

			if ( ! isset( $resultEvents['event'] ) )
			{
				throw new NotFoundException( 'This user isn\'t signed up for any events!' );
			}

			if ( isset( $resultEvents['event'][0] ) && is_array( $resultEvents['event'][0] ) )
			{
				$events = $resultEvents['event'];
			}
			else
			{
				$events = array( $resultEvents['event'] );
			}

			$totalPages = (int) $resultEvents['@attr']['totalPages'];
			$total      = (int) $resultEvents['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $events as $eventRow )
			{
				$ArtistsList = new ArrayCollection();

				foreach ( $eventRow['artists']['artist'] as $artistRow )
				{
					$Artist = new UserData\Artist();
					$Artist->setName( (string) $artistRow );

					$ArtistsList->add( $Artist );
				}

				$Headliner = new UserData\Artist();
				$Headliner->setName( (string) $eventRow['artists']['headliner'] );

				$Venue = new UserData\Venue();

				$Venue
					->setId( (int) $eventRow['venue']['id'] )
					->setName( (string) $eventRow['venue']['name'] )
					->setLatitude( (float) $eventRow['venue']['location']['geo:point']['geo:lat'] )
					->setLongitude( (float) $eventRow['venue']['location']['geo:point']['geo:long'] )
					->setCity( (string) $eventRow['venue']['location']['city'] )
					->setCountry( (string) $eventRow['venue']['location']['country'] )
					->setStreet( (string) $eventRow['venue']['location']['street'] )
					->setPostalcode( (int) $eventRow['venue']['location']['postalcode'] )
					->setUrl( (string) $eventRow['venue']['url'] )
					->setWebsite( (string) $eventRow['venue']['website'] )
					->setPhonenumber( (string) $eventRow['venue']['phonenumber'] );

				if ( isset( $eventRow['venue']['image'] ) )
				{
					$Venue->setImages( $self->getImageList( $eventRow['venue']['image'] ) );
				}

				$Tags = new ArrayCollection();

				if ( isset( $eventRow['tags']['tag'] ) )
				{
					foreach ( $eventRow['tags']['tag'] as $tagRow )
					{
						$Tag = new UserData\Tag();

						$Tag->setName( (string) $tagRow );

						$Tags->add( $Tag );
					}
				}

				$Event = new UserData\Event();

				$Event
					->setId( (int) $eventRow['id'] )
					->setTitle( (string) $eventRow['title'] )
					->setStartDate( new DateTime( (string) $eventRow['startDate'] ) )
					->setDescription( (string) $eventRow['description'] )
					->setAttendance( (int) $eventRow['attendance'] )
					->setReviews( (int) $eventRow['reviews'] )
					->setTag( (string) $eventRow['tag'] )
					->setUrl( (string) $eventRow['url'] )
					->setWebsite( (string) $eventRow['website'] )
					->setCancelled( (int) $eventRow['cancelled'] )
					->setArtists( $ArtistsList )
					->setHeadliner( $Headliner )
					->setVenue( $Venue )
					->setTags( $Tags );

				if ( isset( $eventRow['image'] ) )
				{
					$Event->setImages( $self->getImageList( $eventRow['image'] ) );
				}

				$List->add( $Event );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getFriends
	 *
	 * @param string $user
	 * @param bool $recenttracks
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getFriends( $user, $recenttracks = true )
	{
		$params = array(
			'user'         => $user,
			'recenttracks' => $recenttracks,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params        = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result        = $self->get( User::PREFIX . 'getFriends', $params );
			$resultFriends = $result['friends'];

			if ( ! isset( $resultFriends['user'] ) )
			{
				throw new NotFoundException( 'This user has no friends!' );
			}

			if ( isset( $resultFriends['user'][0] ) && is_array( $resultFriends['user'][0] ) )
			{
				$users = $resultFriends['user'];
			}
			else
			{
				$users = array( $resultFriends['user'] );
			}

			$totalPages = (int) $resultFriends['@attr']['totalPages'];
			$total      = (int) $resultFriends['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $users as $userRow )
			{
				$User = new UserData\User();

				$User
					->setName( (string) $userRow['name'] )
					->setRealname( (string) $userRow['realname'] )
					->setUrl( (string) $userRow['url'] )
					->setId( (int) $userRow['id'] )
					->setCountry( (string) $userRow['country'] )
					->setAge( (int) $userRow['age'] )
					->setGender( (string) $userRow['gender'] )
					->setSubscriber( (bool) $userRow['subscriber'] )
					->setPlaycount( (int) $userRow['playcount'] )
					->setPlaylists( (int) $userRow['playlists'] )
					->setBootstrap( (int) $userRow['bootstrap'] )
					->setRegisteredAt( new DateTime( $userRow['registered']['#text'] ) )
					->setType( (string) $userRow['type'] )
					->setImages( $self->getImageList( $userRow['image'] ) );

				$Track  = new UserData\Track();
				$Artist = new UserData\Artist();
				$Album  = new UserData\Album();

				if ( isset( $userRow['recenttrack'] ) )
				{
					$recentTrackInfo = $userRow['recenttrack'];

					$Artist
						->setName( (string) $recentTrackInfo['artist']['name'] )
						->setMbid( (string) $recentTrackInfo['artist']['mbid'] )
						->setUrl( (string) $recentTrackInfo['artist']['url'] );

					$Album
						->setName( (string) $recentTrackInfo['album']['name'] )
						->setMbid( (string) $recentTrackInfo['album']['mbid'] )
						->setUrl( (string) $recentTrackInfo['album']['url'] );

					$Track
						->setName( (string) $recentTrackInfo['name'] )
						->setMbId( (string) $recentTrackInfo['mbid'] )
						->setUrl( (string) $recentTrackInfo['url'] );
				}

				$Track
					->setArtist( $Artist )
					->setAlbum( $Album );

				$User->setRecentTrack( $Track );

				$List->add( $User );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getInfo
	 *
	 * @param string $user
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function getInfo( $user )
	{
		$params = array(
			'user' => $user,
		);

		$result   = $this->get( self::PREFIX . 'getInfo', $params );
		$userInfo = $result['user'];
		$User     = new UserData\User();

		$User
			->setName( (string) $userInfo['name'] )
			->setRealname( (string) $userInfo['realname'] )
			->setUrl( (string) $userInfo['url'] )
			->setId( (int) $userInfo['id'] )
			->setCountry( (string) $userInfo['country'] )
			->setAge( (int) $userInfo['age'] )
			->setGender( (string) $userInfo['gender'] )
			->setSubscriber( (bool) $userInfo['subscriber'] )
			->setPlaycount( (int) $userInfo['playcount'] )
			->setPlaylists( (int) $userInfo['playlists'] )
			->setBootstrap( (int) $userInfo['bootstrap'] )
			->setRegisteredAt( new DateTime( (string) $userInfo['registered']['#text'] ) )
			->setType( (string) $userInfo['type'] )
			->setImages( $this->getImageList( $userInfo['image'] ) );

		return $User;
	}

	/**
	 * @link http://www.last.fm/api/show/user.getLovedTracks
	 *
	 * @param string $user
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getLovedTracks( $user )
	{
		$params = array(
			'user' => $user,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params            = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result            = $self->get( User::PREFIX . 'getLovedTracks', $params );
			$resultLovedTracks = $result['lovedtracks'];

			if ( ! isset( $resultLovedTracks['track'] ) )
			{
				throw new NotFoundException( 'This user has no lovedtracks!' );
			}

			if ( isset( $resultLovedTracks['track'][0] ) && is_array( $resultLovedTracks['track'][0] ) )
			{
				$tracks = $resultLovedTracks['track'];
			}
			else
			{
				$tracks = array( $resultLovedTracks['track'] );
			}

			$totalPages = (int) $resultLovedTracks['@attr']['totalPages'];
			$total      = (int) $resultLovedTracks['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $trackRow['artist']['name'] )
					->setMbid( (string) $trackRow['artist']['mbid'] )
					->setUrl( (string) $trackRow['artist']['url'] );

				$Track = new UserData\Track();

				$Track
					->setLovedAt( new DateTime( (string) $trackRow['date']['#text'] ) )
					->setName( (string) $trackRow['name'] )
					->setMbid( (string) $trackRow['mbid'] )
					->setUrl( (string) $trackRow['url'] )
					->setArtist( $Artist )
					->setStreamable( (bool) $trackRow['streamable']['#text'] )
					->setStreamableFulltrack( (bool) $trackRow['streamable']['fulltrack'] );

				if ( isset( $trackRow['image'] ) )
				{
					$Track->setImages( $self->getImageList( $trackRow['image'] ) );
				}
				else
				{
					$Track->setImages( new ArrayCollection() );
				}

				$List->add( $Track );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getNeighbours
	 *
	 * @param string $user
	 * @return \Lertify\Lastfm\Api\Data\User\User[]
	 */
	public function getNeighbours( $user )
	{
		$params = array(
			'user' => $user,
		);

		$result           = $this->get( self::PREFIX . 'getNeighbours', $params );
		$resultNeighbours = $result['neighbours'];

		$List = new ArrayCollection();

		foreach ( $resultNeighbours['user'] as $neighbourRow )
		{
			$Neighbour = new UserData\User();

			$Neighbour
				->setName( (string) $neighbourRow['name'] )
				->setRealname( (string) $neighbourRow['realname'] )
				->setUrl( (string) $neighbourRow['url'] )
				->setMatch((float) $neighbourRow['match']  )
				->setImages( $this->getImageList( $neighbourRow['image'] ) );

			$List->add( $Neighbour );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/user.getNewReleases
	 *
	 * @param string $user
	 * @param bool $userecs
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\User\Album[]
	 */
	public function getNewReleases( $user, $userecs = false )
	{
		$params = array(
			'user'    => $user,
			'userecs' => $userecs
		);

		$result       = $this->get( self::PREFIX . 'getNewReleases', $params );
		$resultAlbums = $result['albums'];

		if ( ! isset( $resultAlbums['album'] ) )
		{
			throw new NotFoundException( 'No new releases for this user!' );
		}

		if ( isset( $resultAlbums['album'][0] ) && is_array( $resultAlbums['album'][0] ) )
		{
			$albums = $resultAlbums['album'];
		}
		else
		{
			$albums = array( $resultAlbums['album'] );
		}

		$List = new ArrayCollection();

		foreach ( $albums as $albumRow )
		{
			$Artist = new UserData\Artist();

			$Artist
				->setName( (string) $albumRow['artist']['name'] )
				->setMbid( (string) $albumRow['artist']['mbid'] )
				->setUrl( (string) $albumRow['artist']['url'] );

			$Album = new UserData\Album();

			$Album
				->setName( (string) $albumRow['name'] )
				->setMbid( (string) $albumRow['mbid'] )
				->setUrl( (string) $albumRow['url'] )
				->setReleaseDate( new DateTime( (string) $albumRow['@attr']['releasedate'] ) )
				->setArtist( $Artist )
				->setImages( $this->getImageList( $albumRow['image'] ) );

			$List->add( $Album );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/user.getPastEvents
	 *
	 * @param string $user
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getPastEvents( $user )
	{
		$params = array(
			'user' => $user,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params       = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result       = $self->get( User::PREFIX . 'getPastEvents', $params );
			$resultEvents = $result['events'];

			if ( ! isset( $resultEvents['event'] ) )
			{
				throw new NotFoundException( 'This user has no lovedtracks!' );
			}

			if ( isset( $resultEvents['event'][0] ) && is_array( $resultEvents['event'][0] ) )
			{
				$events = $resultEvents['event'];
			}
			else
			{
				$events = array( $resultEvents['event'] );
			}

			$totalPages = (int) $resultEvents['@attr']['totalPages'];
			$total      = (int) $resultEvents['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $events as $eventRow )
			{
				$ArtistsList = new ArrayCollection();

				if ( isset( $eventRow['artists']['artist'][0] ) && is_array( $eventRow['artists']['artist'][0] ) )
				{
					$artists = $eventRow['artists']['artist'];
				}
				else
				{
					$artists = array( $eventRow['artists']['artist'] );
				}

				foreach ( $artists as $artistRow )
				{
					$Artist = new UserData\Artist();
					$Artist->setName( (string) $artistRow );

					$ArtistsList->add( $Artist );
				}

				$Headliner = new UserData\Artist();
				$Headliner->setName( (string) $eventRow['artists']['headliner'] );

				$Venue = new UserData\Venue();

				$Venue
					->setId( (int) $eventRow['venue']['id'] )
					->setName( (string) $eventRow['venue']['name'] )
					->setLatitude( (float) $eventRow['venue']['location']['geo:point']['geo:lat'] )
					->setLongitude( (float) $eventRow['venue']['location']['geo:point']['geo:long'] )
					->setCity( (string) $eventRow['venue']['location']['city'] )
					->setCountry( (string) $eventRow['venue']['location']['country'] )
					->setStreet( (string) $eventRow['venue']['location']['street'] )
					->setPostalcode( (int) $eventRow['venue']['location']['postalcode'] )
					->setUrl( (string) $eventRow['venue']['url'] )
					->setWebsite( (string) $eventRow['venue']['website'] )
					->setPhonenumber( (string) $eventRow['venue']['phonenumber'] );

				if ( isset( $eventRow['venue']['image'] ) )
				{
					$Venue->setImages( $self->getImageList( $eventRow['venue']['image'] ) );
				}
				else
				{
					$Venue->setImages( new ArrayCollection() );
				}

				$Event = new UserData\Event();

				$Event
					->setId( (int) $eventRow['id'] )
					->setTitle( (string) $eventRow['title'] )
					->setDescription( (string) $eventRow['description'] )
					->setAttendance( (int) $eventRow['attendance'] )
					->setReviews( (int) $eventRow['reviews'] )
					->setTag( (string) $eventRow['tag'] )
					->setUrl( (string) $eventRow['url'] )
					->setWebsite( (string) $eventRow['website'] )
					->setCancelled( (int) $eventRow['cancelled'] )
					->setStartDate( new DateTime( (string) $eventRow['startDate'] ) )
					->setArtists( $ArtistsList )
					->setHeadliner( $Headliner )
					->setImages( $self->getImageList( $eventRow['image'] ) )
					->setVenue( $Venue );

				if ( isset( $eventRow['endDate'] ) )
				{
					$Event->setEndDate( new DateTime( (string) $eventRow['endDate'] ) );
				}

				$List->add( $Event );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getPersonalTags
	 *
	 * @param string $user
	 * @param string $tag
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getPersonalTagsForArtist( $user, $tag )
	{
		$params = array(
			'user'        => $user,
			'tag'         => $tag,
			'taggingtype' => 'artist',
		);

		$self  = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params         = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result         = $self->get( User::PREFIX . 'getPersonalTags', $params );
			$resultTaggings = $result['taggings'];
			$resultArtists  = $resultTaggings['artists'];

			if ( ! isset( $resultArtists['artist'] ) )
			{
				throw new NotFoundException( sprintf( 'This user has no tagged artists with tag: "%s"!', $params['tag'] ) );
			}
			elseif ( is_string( $resultArtists['artist'] ) )
			{
				throw new NotFoundException( sprintf( 'This user has no tagged artists with tag: "%s"!', $params['tag'] ) );
			}

			if ( isset( $resultArtists['artist'][0] ) && is_array( $resultArtists['artist'][0] ) )
			{
				$artists = $resultArtists['artist'];
			}
			else
			{
				$artists = array( $resultArtists['artist'] );
			}

			$totalPages = (int) $resultTaggings['@attr']['totalPages'];
			$total      = (int) $resultTaggings['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $artistRow['name'] )
					->setMbid( (string) $artistRow['mbid'] )
					->setUrl( (string) $artistRow['url'] )
					->setStreamable( (bool) $artistRow['streamable'] )
					->setImages( $self->getImageList( $artistRow['image'] ) );

				$List->add( $Artist );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getPersonalTags
	 *
	 * @param string $user
	 * @param string $tag
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getPersonalTagsForAlbum( $user, $tag )
	{
		$params = array(
			'user'        => $user,
			'tag'         => $tag,
			'taggingtype' => 'album',
		);

		$self  = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params         = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result         = $self->get( User::PREFIX . 'getPersonalTags', $params );
			$resultTaggings = $result['taggings'];
			$resultAlbums   = $resultTaggings['albums'];

			if ( ! isset( $resultAlbums['album'] ) )
			{
				throw new NotFoundException( sprintf( 'This user has no tagged albums with tag: "%s"!', $params['tag'] ) );
			}
			elseif ( is_string( $resultAlbums['album'] ) )
			{
				throw new NotFoundException( sprintf( 'This user has no tagged albums with tag: "%s"!', $params['tag'] ) );
			}

			if ( isset( $resultAlbums['album'][0] ) && is_array( $resultAlbums['album'][0] ) )
			{
				$albums = $resultAlbums['album'];
			}
			else
			{
				$albums = array( $resultAlbums['album'] );
			}

			$totalPages = (int) $resultTaggings['@attr']['totalPages'];
			$total      = (int) $resultTaggings['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $albums as $albumRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $albumRow['artist']['name'] )
					->setMbid( (string) $albumRow['artist']['mbid'] )
					->setUrl( (string) $albumRow['artist']['url'] );

				$Album = new UserData\Album();

				$Album
					->setName( (string) $albumRow['name'] )
					->setMbid( (string) $albumRow['mbid'] )
					->setUrl( (string) $albumRow['url'] )
					->setArtist( $Artist )
					->setImages( $self->getImageList( $albumRow['image'] ) );

				$List->add( $Album );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getPersonalTags
	 *
	 * @param string $user
	 * @param string $tag
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getPersonalTagsForTrack( $user, $tag )
	{
		$params = array(
			'user'        => $user,
			'tag'         => $tag,
			'taggingtype' => 'track',
		);

		$self  = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params         = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result         = $self->get( User::PREFIX . 'getPersonalTags', $params );
			$resultTaggings = $result['taggings'];
			$resultTracks   = $resultTaggings['tracks'];

			if ( ! isset( $resultTracks['track'] ) )
			{
				throw new NotFoundException( sprintf( 'This user has no tagged tracks with tag: "%s"!', $params['tag'] ) );
			}
			elseif ( is_string( $resultTracks['track'] ) )
			{
				throw new NotFoundException( sprintf( 'This user has no tagged tracks with tag: "%s"!', $params['tag'] ) );
			}

			if ( isset( $resultTracks['track'][0] ) && is_array( $resultTracks['track'][0] ) )
			{
				$tracks = $resultTracks['track'];
			}
			else
			{
				$tracks = array( $resultTracks['track'] );
			}

			$totalPages = (int) $resultTaggings['@attr']['totalPages'];
			$total      = (int) $resultTaggings['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $trackRow['artist']['name'] )
					->setMbid( (string) $trackRow['artist']['mbid'] )
					->setUrl( (string) $trackRow['artist']['url'] );

				$Track = new UserData\Track();

				$Track
					->setName( (string) $trackRow['name'] )
					->setDuration( (int) $trackRow['duration'] )
					->setMbId( (string) $trackRow['mbid'] )
					->setUrl( (string) $trackRow['url'] )
					->setStreamable( (bool) $trackRow['streamable']['#text'] )
					->setStreamableFulltrack( (bool) $trackRow['streamable']['fulltrack'] )
					->setArtist( $Artist )
					->setImages( $self->getImageList( $trackRow['image'] ) );

				$List->add( $Track );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getPlaylists
	 *
	 * @param string $user
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getPlaylists( $user )
	{
		$params = array(
			'user' => $user,
		);

		$result          = $this->get( self::PREFIX . 'getPlaylists', $params );
		$resultPlaylists = $result['playlists'];

		if ( ! isset( $resultPlaylists['playlist'] ) )
		{
			throw new NotFoundException( 'This user has no playlists!' );
		}

		if ( isset( $resultPlaylists['playlist'][0] ) && is_array( $resultPlaylists['playlist'][0] ) )
		{
			$playlists = $resultPlaylists['playlist'];
		}
		else
		{
			$playlists = array( $resultPlaylists['playlist'] );
		}

		$List = new ArrayCollection();

		foreach ( $playlists as $playlistRow )
		{
			$Playlist = new UserData\Playlist();

			$Playlist
				->setId( (int) $playlistRow['id'] )
				->setTitle( (string) $playlistRow['title'] )
				->setDescription( (string) $playlistRow['description'] )
				->setSize( (int) $playlistRow['size'] )
				->setDuration( (int) $playlistRow['duration'] )
				->setStreamable( (bool) $playlistRow['streamable'] )
				->setCreator( (string) $playlistRow['creator'] )
				->setUrl( (string) $playlistRow['url'] )
				->setDate( new DateTime( (string) $playlistRow['date'] ) )
				->setImages( $this->getImageList( $playlistRow['image'] ) );

			$List->add( $Playlist );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/user.getRecentStations
	 *
	 * @param string $user
	 * @param string $sk
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getRecentStations( $user, $sk )
	{
		$params = array(
			'user' => $user,
			'sk'   => $sk,
		);

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result = $self->get( User::PREFIX . 'getRecentStations', $params, array( 'is_signed' => true ) );

			// @todo Incomplete due to bug fix page and limit parameters

			return array(
				'results'       => new ArrayCollection(),
				'total_pages'   => 0,
				'total_results' => 0,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getRecentTracks
	 *
	 * @param string $user
	 * @param \DateTime|null $From
	 * @param \DateTime|null $To
	 * @param bool $extended
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getRecentTracks( $user, DateTime $From = null, DateTime $To = null, $extended = false )
	{
		$params = array(
			'user'     => $user,
			'extended' => $extended,
		);

		if ( null !== $From )
		{
			$params['from'] = $From->getTimestamp();
		}
		else
		{
			$params['from'] = $From;
		}

		if ( null !== $To )
		{
			$params['to'] = $To->getTimestamp();
		}
		else
		{
			$params['to'] = $To;
		}

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params             = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result             = $self->get( User::PREFIX . 'getRecentTracks', $params );
			$resultRecenttracks = $result['recenttracks'];

			if ( ! isset( $resultRecenttracks['track'] ) )
			{
				throw new NotFoundException( 'This user has no recent tracks!' );
			}

			if ( isset( $resultRecenttracks['track'][0] ) && is_array( $resultRecenttracks['track'][0] ) )
			{
				$tracks = $resultRecenttracks['track'];
			}
			else
			{
				$tracks = array( $resultRecenttracks['track'] );
			}

			$totalPages = (int) $resultRecenttracks['@attr']['totalPages'];
			$total      = (int) $resultRecenttracks['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $trackRow['artist']['#text'] )
					->setMbid( (string) $trackRow['artist']['mbid'] );

				$Album = new UserData\Album();

				$Album
					->setName( (string) $trackRow['album']['#text'] )
					->setMbid( (string) $trackRow['album']['mbid'] );

				$Track = new UserData\Track();

				$Track
					->setPlayedAt( new DateTime( (string) $trackRow['date']['#text'] ) )
					->setName( (string) $trackRow['name'] )
					->setStreamable( (bool) $trackRow['streamable'] )
					->setMbId( (string) $trackRow['mbid'] )
					->setUrl( (string) $trackRow['url'] )
					->setImages( $self->getImageList( $trackRow['image'] ) )
					->setArtist( $Artist )
					->setAlbum( $Album );

				$List->add( $Track );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getRecommendedArtists
	 *
	 * @param string $sk
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getRecommendedArtists( $sk )
	{
		$params = array(
			'sk' => $sk,
		);

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result = $self->get( User::PREFIX . 'getRecommendedArtists', $params, array( 'is_signed' => true ) );

			// @todo Incomplete due to bug fix page and limit parameters

			return array(
				'results'       => new ArrayCollection(),
				'total_pages'   => 0,
				'total_results' => 0,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getRecommendedEvents
	 *
	 * @param string $sk
	 * @param bool $festivalsonly
	 * @param float|null $latitude
	 * @param float|null $longitude
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getRecommendedEventsByCoordinates( $sk, $festivalsonly = false, $latitude = null, $longitude = null )
	{
		$params = array(
			'festivalsonly' => $festivalsonly,
			'latitude'      => $latitude,
			'longitude'     => $longitude,
			'sk'            => $sk,
		);

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result = $self->get( User::PREFIX . 'getRecommendedEvents', $params, array( 'is_signed' => true ) );

			// @todo Incomplete due to bug fix page and limit parameters

			return array(
				'results'       => new ArrayCollection(),
				'total_pages'   => 0,
				'total_results' => 0,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getRecommendedEvents
	 *
	 * @param string $sk
	 * @param bool $festivalsonly
	 * @param string|null $country
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getRecommendedEventsByCountry( $sk, $festivalsonly = false, $country = null )
	{
		$params = array(
			'festivalsonly' => $festivalsonly,
			'country'       => (string) $country,
			'sk'            => $sk,
		);

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result = $self->get( User::PREFIX . 'getRecommendedEvents', $params, array( 'is_signed' => true ) );

			// @todo Incomplete due to bug fix page and limit parameters

			return array(
				'results'       => new ArrayCollection(),
				'total_pages'   => 0,
				'total_results' => 0,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getShouts
	 *
	 * @param string $user
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getShouts( $user )
	{
		$params = array(
			'user' => $user,
		);

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params       = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result       = $self->get( User::PREFIX . 'getShouts', $params );
			$resultShouts = $result['shouts'];

			if ( ! isset( $resultShouts['shout'] ) )
			{
				throw new NotFoundException( 'This user has no shouts!' );
			}

			if ( isset( $resultShouts['shout'][0] ) && is_array( $resultShouts['shout'][0] ) )
			{
				$shouts = $resultShouts['shout'];
			}
			else
			{
				$shouts = array( $resultShouts['shout'] );
			}

			$totalPages = (int) $resultShouts['@attr']['totalPages'];
			$total      = (int) $resultShouts['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $shouts as $shoutRow )
			{
				$Author = new UserData\User();

				$Author->setName( (string) $shoutRow['author'] );

				$Shout = new UserData\Shout();

				$Shout
					->setBody( (string) $shoutRow['body'] )
					->setAuthor( $Author )
					->setDate( new DateTime( (string) $shoutRow['date'] ) );

				$List->add( $Shout );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getTopAlbums
	 *
	 * @param string $user
	 * @param string|null $period (overall | 7day | 1month | 3month | 6month | 12month)
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopAlbums( $user, $period = null )
	{
		$params = array(
			'user'   => $user,
			'period' => $period
		);

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params          = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result          = $self->get( User::PREFIX . 'getTopAlbums', $params );
			$resultTopalbums = $result['topalbums'];

			if ( ! isset( $resultTopalbums['album'] ) )
			{
				throw new NotFoundException( 'This user has no top albums!' );
			}

			if ( isset( $resultTopalbums['album'][0] ) && is_array( $resultTopalbums['album'][0] ) )
			{
				$topAlbums = $resultTopalbums['album'];
			}
			else
			{
				$topAlbums = array( $resultTopalbums['album'] );
			}

			$totalPages = (int) $resultTopalbums['@attr']['totalPages'];
			$total      = (int) $resultTopalbums['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $topAlbums as $topAlbumRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $topAlbumRow['artist']['name'] )
					->setMbid( (string) $topAlbumRow['artist']['mbid'] )
					->setUrl( (string) $topAlbumRow['artist']['url'] );

				$TopAlbum = new UserData\Album();

				$TopAlbum
					->setName( (string) $topAlbumRow['name'] )
					->setPlaycount( (int) $topAlbumRow['playcount'] )
					->setMbid( (string) $topAlbumRow['mbid'] )
					->setUrl( (string) $topAlbumRow['url'] )
					->setImages( $self->getImageList( $topAlbumRow['image'] ) )
					->setArtist( $Artist );

				$List->add( $TopAlbum );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getTopArtists
	 *
	 * @param string $user
	 * @param string|null $period (overall | 7day | 1month | 3month | 6month | 12month)
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopArtists( $user, $period = null )
	{
		$params = array(
			'user'   => $user,
			'period' => $period,
		);

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params           = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result           = $self->get( User::PREFIX . 'getTopArtists', $params );
			$resultTopartists = $result['topartists'];

			if ( ! isset( $resultTopartists['artist'] ) )
			{
				throw new NotFoundException( 'This user has no top artists!' );
			}

			if ( isset( $resultTopartists['artist'][0] ) && is_array( $resultTopartists['artist'][0] ) )
			{
				$topArtists = $resultTopartists['artist'];
			}
			else
			{
				$topArtists = array( $resultTopartists['artist'] );
			}

			$totalPages = (int) $resultTopartists['@attr']['totalPages'];
			$total      = (int) $resultTopartists['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $topArtists as $topArtistRow )
			{
				$TopArtist = new UserData\Artist();

				$TopArtist
					->setName( (string) $topArtistRow['name'] )
					->setPlaycount( (int) $topArtistRow['playcount'] )
					->setMbid( (string) $topArtistRow['mbid'] )
					->setUrl( (string) $topArtistRow['url'] )
					->setStreamable( (bool) $topArtistRow['streamable'] )
					->setRank( (int) $topArtistRow['@attr']['rank'] )
					->setImages( $self->getImageList( $topArtistRow['image'] ) );

				$List->add( $TopArtist );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getTopTags
	 *
	 * @param string $user
	 * @param int $limit
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTopTags( $user, $limit = 30 )
	{
		$params = array(
			'user'  => $user,
			'limit' => $limit,
		);

		$result        = $this->get( self::PREFIX . 'getTopTags', $params );
		$resultToptags = $result['toptags'];

		if ( ! isset( $resultToptags['tag'] ) )
		{
			throw new NotFoundException( 'This user has no top tags!' );
		}

		if ( isset( $resultToptags['tag'][0] ) && is_array( $resultToptags['tag'][0] ) )
		{
			$topTags = $resultToptags['tag'];
		}
		else
		{
			$topTags = array( $resultToptags['tag'] );
		}

		$List = new ArrayCollection();

		foreach ( $topTags as $topTagRow )
		{
			$TopTag = new UserData\Tag();

			$TopTag
				->setName( (string) $topTagRow['name'] )
				->setCount( (int) $topTagRow['count'] )
				->setUrl( (string) $topTagRow['url'] );

			$List->add( $TopTag );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/user.getTopTracks
	 *
	 * @param string $user
	 * @param string|null $period (overall | 7day | 1month | 3month | 6month | 12month)
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopTracks( $user, $period = null )
	{
		$params = array(
			'user'   => $user,
			'period' => $period,
		);

		$self           = $this;
		$resultCallback = function ( $page, $limit ) use ( $params, $self )
		{
			$params          = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result          = $self->get( User::PREFIX . 'getTopTracks', $params );
			$resultToptracks = $result['toptracks'];

			if ( ! isset( $resultToptracks['track'] ) )
			{
				throw new NotFoundException( 'This user has no top tracks!' );
			}

			if ( isset( $resultToptracks['track'][0] ) && is_array( $resultToptracks['track'][0] ) )
			{
				$topTracks = $resultToptracks['track'];
			}
			else
			{
				$topTracks = array( $resultToptracks['track'] );
			}

			$totalPages = (int) $resultToptracks['@attr']['totalPages'];
			$total      = (int) $resultToptracks['@attr']['total'];

			$List = new ArrayCollection();

			foreach ( $topTracks as $topTrackRow )
			{
				$Artist = new UserData\Artist();

				$Artist
					->setName( (string) $topTrackRow['artist']['name'] )
					->setMbid( (string) $topTrackRow['artist']['mbid'] )
					->setUrl( (string) $topTrackRow['artist']['url'] );

				$TopTrack = new UserData\Track();

				$TopTrack
					->setName( (string) $topTrackRow['name'] )
					->setDuration( (int) $topTrackRow['duration'] )
					->setPlaycount( (int) $topTrackRow['playcount'] )
					->setMbId( (string) $topTrackRow['mbid'] )
					->setUrl( (string) $topTrackRow['url'] )
					->setStreamable( (bool) $topTrackRow['streamable']['#text'] )
					->setStreamableFulltrack( (bool) $topTrackRow['streamable']['fulltrack'] )
					->setRank( (int) $topTrackRow['@attr']['rank'] )
					->setArtist( $Artist );

				if ( isset( $topTrackRow['image'] ) )
				{
					$TopTrack->setImages( $self->getImageList( $topTrackRow['image'] ) );
				}
				else
				{
					$TopTrack->setImages( new ArrayCollection() );
				}

				$List->add( $TopTrack );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $total,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/user.getWeeklyAlbumChart
	 *
	 * @param string $user
	 * @param \DateTime|null $From
	 * @param \DateTime|null $To
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getWeeklyAlbumChart( $user, DateTime $From = null, DateTime $To = null )
	{
		$params = array(
			'user' => $user,
		);

		if ( null !== $From )
		{
			$params['from'] = $From->getTimestamp();
		}
		else
		{
			$params['from'] = $From;
		}

		if ( null !== $To )
		{
			$params['to'] = $To->getTimestamp();
		}
		else
		{
			$params['to'] = $To;
		}

		$result                 = $this->get( self::PREFIX . 'getWeeklyAlbumChart', $params );
		$resultWeeklyalbumchart = $result['weeklyalbumchart'];

		if ( ! isset( $resultWeeklyalbumchart['album'] ) )
		{
			throw new NotFoundException( 'This user has no albums in weekly chart!' );
		}

		if ( isset( $resultWeeklyalbumchart['album'][0] ) && is_array( $resultWeeklyalbumchart['album'][0] ) )
		{
			$albums = $resultWeeklyalbumchart['album'];
		}
		else
		{
			$albums = array( $resultWeeklyalbumchart['album'] );
		}

		$List = new ArrayCollection();

		foreach ( $albums as $albumRow )
		{
			$Artist = new UserData\Artist();

			$Artist
				->setName( (string) $albumRow['artist']['#text'] )
				->setMbid( (string) $albumRow['artist']['mbid'] );

			$Album = new UserData\Album();

			$Album
				->setName( (string) $albumRow['name'] )
				->setMbid( (string) $albumRow['mbid'] )
				->setPlaycount( (int) $albumRow['playcount'] )
				->setUrl( (string) $albumRow['url'] )
				->setArtist( $Artist );

			$List->add( $Album );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/user.getWeeklyArtistChart
	 *
	 * @param string $user
	 * @param \DateTime|null $From
	 * @param \DateTime|null $To
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getWeeklyArtistChart( $user, DateTime $From = null, DateTime $To = null )
	{
		$params = array(
			'user' => $user,
		);

		if ( null !== $From )
		{
			$params['from'] = $From->getTimestamp();
		}
		else
		{
			$params['from'] = $From;
		}

		if ( null !== $To )
		{
			$params['to'] = $To->getTimestamp();
		}
		else
		{
			$params['to'] = $To;
		}

		$result                  = $this->get( self::PREFIX . 'getWeeklyArtistChart', $params );
		$resultWeeklyartistchart = $result['weeklyartistchart'];

		if ( ! isset( $resultWeeklyartistchart['artist'] ) )
		{
			throw new NotFoundException( 'This user has no artists in weekly chart!' );
		}

		if ( isset( $resultWeeklyartistchart['artist'][0] ) && is_array( $resultWeeklyartistchart['artist'][0] ) )
		{
			$artists = $resultWeeklyartistchart['artist'];
		}
		else
		{
			$artists = array( $resultWeeklyartistchart['artist'] );
		}

		$List = new ArrayCollection();

		foreach ( $artists as $artistRow )
		{
			$Artist = new UserData\Artist();

			$Artist
				->setName( (string) $artistRow['name'] )
				->setMbid( (string) $artistRow['mbid'] )
				->setPlaycount( (int) $artistRow['playcount'] )
				->setUrl( (string) $artistRow['url'] )
				->setRank( (int) $artistRow['@attr']['rank'] );

			$List->add( $Artist );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/user.getWeeklyTrackChart
	 *
	 * @param string $user
	 * @param \DateTime|null $From
	 * @param \DateTime|null $To
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getWeeklyTrackChart( $user, DateTime $From = null, DateTime $To = null )
	{
		$params = array(
			'user' => $user,
		);

		if ( null !== $From )
		{
			$params['from'] = $From->getTimestamp();
		}
		else
		{
			$params['from'] = $From;
		}

		if ( null !== $To )
		{
			$params['to'] = $To->getTimestamp();
		}
		else
		{
			$params['to'] = $To;
		}

		$result                 = $this->get( self::PREFIX . 'getWeeklyTrackChart', $params );
		$resultWeeklytrackchart = $result['weeklytrackchart'];

		if ( ! isset( $resultWeeklytrackchart['track'] ) )
		{
			throw new NotFoundException( 'This user has no tracks in weekly chart!' );
		}

		if ( isset( $resultWeeklytrackchart['track'][0] ) && is_array( $resultWeeklytrackchart['track'][0] ) )
		{
			$tracks = $resultWeeklytrackchart['track'];
		}
		else
		{
			$tracks = array( $resultWeeklytrackchart['track'] );
		}

		$List = new ArrayCollection();

		foreach ( $tracks as $trackRow )
		{
			$Artist = new UserData\Artist();

			$Artist
				->setName( (string) $trackRow['artist']['#text'] )
				->setMbid( (string) $trackRow['artist']['mbid'] );

			$Track = new UserData\Track();

			$Track
				->setName( (string) $trackRow['name'] )
				->setMbId( (string) $trackRow['mbid'] )
				->setUrl( (string) $trackRow['url'] )
				->setRank( (int) $trackRow['@attr']['rank'] )
				->setPlaycount( (int) $trackRow['playcount'] )
				->setImages( $this->getImageList( $trackRow['image'] ) )
				->setArtist( $Artist );

			$List->add( $Track );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/user.getWeeklyChartList
	 *
	 * @param string $user
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getWeeklyChartList( $user )
	{
		$params = array(
			'user' => $user,
		);

		$result                = $this->get( self::PREFIX . 'getWeeklyChartList', $params );
		$resultWeeklychartlist = $result['weeklychartlist'];

		if ( ! isset( $resultWeeklychartlist['chart'] ) )
		{
			throw new NotFoundException( 'This user has no records in weekly chart!' );
		}

		if ( isset( $resultWeeklychartlist['chart'][0] ) && is_array( $resultWeeklychartlist['chart'][0] ) )
		{
			$charts = $resultWeeklychartlist['chart'];
		}
		else
		{
			$charts = array( $resultWeeklychartlist['chart'] );
		}

		$List = new ArrayCollection();

		foreach ( $charts as $chartRow )
		{
			$Chart = new UserData\Chart();

			$From = new DateTime();
			$From->setTimestamp( $chartRow['from'] );

			$To = new DateTime();
			$To->setTimestamp( $chartRow['to'] );

			$Chart
				->setFrom( $From )
				->setTo( $To );

			$List->add( $Chart );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/user.shout
	 *
	 * @param string $user
	 * @param string $message
	 * @param string $sk
	 * @return string
	 */
	public function shout( $user, $message, $sk )
	{
		$params = array(
			'user'    => $user,
			'message' => $message,
			'sk'      => $sk,
		);

		$result = $this->post( self::PREFIX . 'shout', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @param array $images
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getImageList( array $images )
	{
		$ImagesList = new ArrayCollection();

		foreach ( $images as $image )
		{
			$ImagesList->set( (string) $image['size'], (string) $image['#text'] );
		}

		return $ImagesList;
	}
}