<?php
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
	 * @link http://www.last.fm/api/show/artist.getInfo
	 *
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
	 * @link http://www.last.fm/api/show/artist.getInfo
	 *
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
	 * @link http://www.last.fm/api/show/artist.getPastEvents
	 *
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
	 * @link http://www.last.fm/api/show/artist.getPastEvents
	 *
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
	 * @link http://www.last.fm/api/show/artist.getPodcast
	 *
	 * @param string $artist
	 * @param bool $autocorrect
	 */
	public function getPodcast( $artist, $autocorrect = false )
	{
		// @todo Can't implement at the moment, due to missing viable working example
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getPodcast
	 *
	 * @param string $mbid
	 */
	public function getPodcastByMbid( $mbid )
	{
		// @todo Can't implement at the moment, due to missing viable working example
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getShouts
	 *
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
	 * @link http://www.last.fm/api/show/artist.getShouts
	 *
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
	 * @link http://www.last.fm/api/show/artist.getSimilar
	 *
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
	 * @link http://www.last.fm/api/show/artist.getSimilar
	 *
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
	 * @link http://www.last.fm/api/show/artist.getTags
	 *
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
	 * @link http://www.last.fm/api/show/artist.getTags
	 *
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
	 * @link http://www.last.fm/api/show/artist.getTags
	 *
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
	 * @link http://www.last.fm/api/show/artist.getTags
	 *
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
	 * @link http://www.last.fm/api/show/artist.getTopAlbums
	 *
	 * @param string $artist
	 * @param bool $autocorrect
	 * @return PagedCollection
	 */
	public function getTopAlbums( $artist, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTopAlbums( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getTopAlbums
	 *
	 * @param string $mbid
	 * @return PagedCollection
	 */
	public function getTopAlbumsByMbid( $mbid )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchTopAlbums( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getTopFans
	 *
	 * @param string $artist
	 * @param bool $autocorrect
	 * @return ArrayCollection
	 */
	public function getTopFans( $artist, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTopFans( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getTopFans
	 *
	 * @param string $mbid
	 * @return ArrayCollection
	 */
	public function getTopFansByMbid( $mbid )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchTopFans( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getTopTags
	 *
	 * @param string $artist
	 * @param bool $autocorrect
	 * @return ArrayCollection
	 */
	public function getTopTags( $artist, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTopTags( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getTopTags
	 *
	 * @param string $mbid
	 * @return ArrayCollection
	 */
	public function getTopTagsByMbid( $mbid )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchTopTags( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getTopTracks
	 *
	 * @param string $artist
	 * @param bool $autocorrect
	 * @return PagedCollection
	 */
	public function getTopTracks( $artist, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTopTracks( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.getTopTracks
	 *
	 * @param string $mbid
	 * @return PagedCollection
	 */
	public function getTopTracksByMbid( $mbid )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchTopTracks( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.removeTag
	 *
	 * @param string $artist
	 * @param string $tag
	 * @param string $sk
	 * @return string
	 */
	public function removeTag( $artist, $tag, $sk )
	{
		$params = array(
			'artist' => $artist,
			'tag'    => $tag,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'removeTag', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/artist.search
	 *
	 * @param string $artist
	 * @return PagedCollection
	 */
	public function search( $artist )
	{
		$self   = $this;
		$params = array(
			'artist' => $artist,
		);

		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Artist */
			$result  = $self->get( Artist::PREFIX . 'search', $params );
			$results = $result['results'];

			$totalResults = (int) $results['opensearch:totalResults'];
			$itemsPerPage = (int) $results['opensearch:itemsPerPage'];

			if ( empty( $results['artistmatches'] ) )
			{
				return null;
			}

			if ( isset( $results['artistmatches']['artist'][0] ) )
			{
				$artistList = $results['artistmatches']['artist'];
			}
			else
			{
				$artistList = array( $results['artistmatches']['artist'] );
			}

			$Artists = new ArrayCollection();

			foreach ( $artistList as $artistRow )
			{
				$Artist = new Data\Artist\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );

				if ( isset( $artistRow['listeners'] ) )
				{
					$Artist->setListeners( (int) $artistRow['listeners'] );
				}

				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );

				$ArtistImages = new ArrayCollection();

				foreach ( $artistRow['image'] as $image )
				{
					$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}

				$Artist->setImages( $ArtistImages );
				$Artists->add( $Artist );
			}

			return array(
				'results'       => $Artists,
				'total_pages'   => ceil( $totalResults / $itemsPerPage ),
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/artist.share
	 *
	 * @param string $artist
	 * @param string|array $recipient
	 * @param string $sk
	 * @param bool $public
	 * @param string|null $message
	 * @throws InvalidArgumentException
	 * @return string
	 */
	public function share( $artist, $recipient, $sk, $public = false, $message = null )
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
			'artist'    => $artist,
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
	 * @link http://www.last.fm/api/show/artist.shout
	 *
	 * @param string $artist
	 * @param string $message
	 * @param string $sk
	 */
	public function shout( $artist, $message, $sk )
	{
		$params = array(
			'artist'  => $artist,
			'message' => $message,
			'sk'      => $sk,
		);

		$result = $this->post( self::PREFIX . 'shout', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @param array $params
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	private function fetchTopTracks( array $params )
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Artist */
			$result          = $self->get( Artist::PREFIX . 'getTopTracks', $params );
			$resultToptracks = $result['toptracks'];

			if ( ! isset( $resultToptracks['track'] ) )
			{
				throw new NotFoundException( 'No toptracks found for this artist!' );
			}

			$totalResults = (int) $resultToptracks['@attr']['total'];
			$totalPages   = (int) $resultToptracks['@attr']['totalPages'];

			$List = new ArrayCollection();

			if ( isset( $resultToptracks['track'][0] ) )
			{
				$tracks = $resultToptracks['track'];
			}
			else
			{
				$tracks = array( $resultToptracks['track'] );
			}

			foreach ( $tracks as $trackRow )
			{
				$Track = new Data\Artist\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setDuration( (int) $trackRow['duration'] );
				$Track->setPlaycount( (int) $trackRow['playcount'] );
				$Track->setListeners( (int) $trackRow['listeners'] );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );

				$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['fulltrack'] ) );
				$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );

				$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

				$Track->setRank( (int) $trackRow['@attr']['rank'] );

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
	 * @param array $params
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	private function fetchTopTags( array $params )
	{
		$result        = $this->get( self::PREFIX . 'getTopTags', $params );
		$resultToptags = $result['toptags'];

		if ( ! isset( $resultToptags['tag'] ) )
		{
			throw new NotFoundException( 'No toptags found for this artist!' );
		}

		if ( isset( $resultToptags['tag'][0] ) )
		{
			$tags = $resultToptags['tag'];
		}
		else
		{
			$tags = array( $resultToptags['tag'] );
		}

		$TopTagsList = new ArrayCollection();

		foreach ( $tags as $tagRow )
		{
			$Tag = new Data\Tag();

			$Tag->setName( Util::toSting( $tagRow['name'] ) );
			$Tag->setCount( (int) $tagRow['count'] );
			$Tag->setUrl( Util::toSting( $tagRow['url'] ) );

			$TopTagsList->add( $Tag );
		}

		return $TopTagsList;
	}

	/**
	 * @param array $params
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	private function fetchTopFans( array $params )
	{
		$result        = $this->get( self::PREFIX . 'getTopFans', $params );
		$resultTopfans = $result['topfans'];

		if ( ! isset( $resultTopfans['user'] ) )
		{
			throw new NotFoundException( 'No topfans found for this artist!' );
		}

		if ( isset( $resultTopfans['user'][0] ) )
		{
			$fans = $resultTopfans['user'];
		}
		else
		{
			$fans = array( $resultTopfans['user'] );
		}

		$TopFansList = new ArrayCollection();

		foreach ( $fans as $fanRow )
		{
			$Fan = new Data\Artist\Fan();

			$Fan->setName( Util::toSting( $fanRow['name'] ) );
			$Fan->setRealName( Util::toSting( $fanRow['realname'] ) );
			$Fan->setUrl( Util::toSting( $fanRow['url'] ) );
			$Fan->setWeight( (int) $fanRow['weight'] );

			$FanImages = new ArrayCollection();

			foreach ( $fanRow['image'] as $imageRow )
			{
				$FanImages->set( Util::toSting( $imageRow['size'] ), Util::toSting( $imageRow['#text'] ) );
			}

			$Fan->setImages( $FanImages );

			$TopFansList->add( $Fan );
		}

		return $TopFansList;
	}

	/**
	 * @param array $params
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	private function fetchTopAlbums( array $params )
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Artist */
			$result          = $self->get( Artist::PREFIX . 'getTopAlbums', $params );
			$resultTopalbums = $result['topalbums'];

			if ( ! isset( $resultTopalbums['album'] ) )
			{
				throw new NotFoundException( 'No topalbums found for this artist!' );
			}

			$totalResults = (int) $resultTopalbums['@attr']['total'];
			$totalPages   = (int) $resultTopalbums['@attr']['totalPages'];

			$List = new ArrayCollection();

			if ( isset( $resultTopalbums['album'][0] ) )
			{
				$albums = $resultTopalbums['album'];
			}
			else
			{
				$albums = array( $resultTopalbums['album'] );
			}

			foreach ( $albums as $albumsRow )
			{
				$Album = new Data\Artist\Album();

				$Album->setName( Util::toSting( $albumsRow['name'] ) );
				$Album->setPlaycount( (int) $albumsRow['playcount'] );
				$Album->setMbid( Util::toSting( $albumsRow['mbid'] ) );
				$Album->setUrl( Util::toSting( $albumsRow['url'] ) );
				$Album->setRank( (int) $albumsRow['@attr']['rank'] );

				$Artist = new Data\Artist\Artist();

				$Artist->setName( Util::toSting( $albumsRow['artist']['name'] ) );
				$Artist->setMbid( Util::toSting( $albumsRow['artist']['mbid'] ) );
				$Artist->setUrl( Util::toSting( $albumsRow['artist']['url'] ) );

				$Album->setArtist( $Artist );

				$ArtistImages = new ArrayCollection();

				foreach ( $albumsRow['image'] as $imageRow )
				{
					$ArtistImages->set( Util::toSting( $imageRow['size'] ), Util::toSting( $imageRow['#text'] ) );
				}

				$Album->setImages( $ArtistImages );

				$List->add( $Album );
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
