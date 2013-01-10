<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Util\Util;

class Library extends AbstractApi
{
	const
		PREFIX = 'library.';

	/**
	 * @link http://www.last.fm/api/show/library.addAlbum
	 *
	 * @param string $artist
	 * @param string $album
	 * @param string $sk
	 * @return string
	 */
	public function addAlbum( $artist, $album, $sk )
	{
		$params = array(
			'artist' => $artist,
			'album'  => $album,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'addAlbum', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/library.addArtist
	 *
	 * @param string $artist
	 * @param string $sk
	 * @return string
	 */
	public function addArtist( $artist, $sk )
	{
		$params = array(
			'artist' => $artist,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'addArtist', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/library.addTrack
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $sk
	 * @return string
	 */
	public function addTrack( $artist, $track, $sk )
	{
		$params = array(
			'artist' => $artist,
			'track'  => $track,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'addTrack', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @param string $user
	 * @param string|null $artist
	 * @return PagedCollection
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 */
	public function getAlbums( $user, $artist = null )
	{
		$params = array(
			'user'   => $user,
			'artist' => $artist,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params       = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result       = $self->get( Library::PREFIX . 'getAlbums', $params );
			$resultAlbums = $result['albums'];

			if ( ! isset( $resultAlbums['album'] ) )
			{
				throw new NotFoundException( 'This user hasn\'t any albums in his library!' );
			}

			$totalResults = (int) $resultAlbums['@attr']['total'];
			$totalPages   = (int) $resultAlbums['@attr']['totalPages'];

			if ( isset( $resultAlbums['album'][0] ) )
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
				$Album = new Data\Library\Album();

				$Album->setName( Util::toSting( $albumRow['name'] ) );
				$Album->setPlaycount( (int) $albumRow['playcount'] );
				$Album->setTagcount( (int) $albumRow['tagcount'] );
				$Album->setMbid( Util::toSting( $albumRow['mbid'] ) );
				$Album->setUrl( Util::toSting( $albumRow['url'] ) );

				$Arist = new Data\Library\Artist();

				$Arist->setName( Util::toSting( $albumRow['artist']['name'] ) );
				$Arist->setMbid( Util::toSting( $albumRow['artist']['mbid'] ) );
				$Arist->setUrl( Util::toSting( $albumRow['artist']['url'] ) );

				$Album->setArtist( $Arist );

				$AlbumImages = new ArrayCollection();

				foreach ( $albumRow['image'] as $image )
				{
					$AlbumImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}

				$Album->setImages( $AlbumImages );
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
	 * @link http://www.last.fm/api/show/library.getArtists
	 *
	 * @param string $user
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return PagedCollection
	 */
	public function getArtists( $user )
	{
		$params = array(
			'user' => $user,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params        = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result        = $self->get( Library::PREFIX . 'getArtists', $params );
			$resultArtists = $result['artists'];

			if ( ! isset( $resultArtists['artist'] ) )
			{
				throw new NotFoundException( 'This user hasn\'t any artists in his library!' );
			}

			$totalResults = (int) $resultArtists['@attr']['total'];
			$totalPages   = (int) $resultArtists['@attr']['totalPages'];

			if ( isset( $resultArtists['artist'][0] ) )
			{
				$artists = $resultArtists['artist'];
			}
			else
			{
				$artists = array( $resultArtists['artist'] );
			}

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new Data\Library\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );
				$Artist->setPlaycount( (int) $artistRow['playcount'] );
				$Artist->setTagcount( (int) $artistRow['tagcount'] );
				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) $artistRow['streamable'] );

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
	 * @link http://www.last.fm/api/show/library.getTracks
	 *
	 * @param string $user
	 * @param string|null $artist
	 * @param string|null $album
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return PagedCollection
	 */
	public function getTracks( $user, $artist = null, $album = null )
	{
		$params = array(
			'user'   => $user,
			'artist' => $artist,
			'album'  => $album,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params       = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result       = $self->get( Library::PREFIX . 'getTracks', $params );
			$resultTracks = $result['tracks'];

			if ( ! isset( $resultTracks['track'] ) )
			{
				throw new NotFoundException( 'This user hasn\'t any tracks in his library!' );
			}

			$totalResults = (int) $resultTracks['@attr']['total'];
			$totalPages   = (int) $resultTracks['@attr']['totalPages'];

			if ( isset( $resultTracks['track'][0] ) )
			{
				$tracks = $resultTracks['track'];
			}
			else
			{
				$tracks = array( $resultTracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $tracks as $tracksRow )
			{
				$Track = new Data\Library\Track();

				$Track->setName( Util::toSting( $tracksRow['name'] ) );
				$Track->setDuration( (int) $tracksRow['name'] );
				$Track->setPlaycount( (int) $tracksRow['playcount'] );
				$Track->setTagcount( (int) $tracksRow['tagcount'] );
				$Track->setMbId( Util::toSting( $tracksRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $tracksRow['url'] ) );

				$Track->setStreamable( (bool) $tracksRow['streamable']['#text'] );
				$Track->setStreamableFulltrack( (bool) $tracksRow['streamable']['fulltrack'] );

				$Track->setArtistName( Util::toSting( $tracksRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $tracksRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $tracksRow['artist']['url'] ) );

				if ( isset( $tracksRow['album'] ) )
				{
					$Track->setAlbumName( Util::toSting( $tracksRow['album']['name'] ) );
					$Track->setAlbumPosition( (int) $tracksRow['album']['position'] );
				}

				$TrackImages = new ArrayCollection();

				if ( isset( $tracksRow['image'] ) )
				{
					foreach ( $tracksRow['image'] as $image )
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
	 * @link http://www.last.fm/api/show/library.removeAlbum
	 *
	 * @param string $artist
	 * @param string $album
	 * @param string $sk
	 * @return string
	 */
	public function removeAlbum( $artist, $album, $sk )
	{
		$params = array(
			'artist' => $artist,
			'album'  => $album,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'removeAlbum', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/library.removeArtist
	 *
	 * @param string $artist
	 * @param string $sk
	 * @return string
	 */
	public function removeArtist( $artist, $sk )
	{
		$params = array(
			'artist' => $artist,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'removeArtist', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/library.removeScrobble
	 *
	 * @param string $artist
	 * @param string $track
	 * @param int $timestamp
	 * @param string $sk
	 * @return string
	 */
	public function removeScrobble( $artist, $track, $timestamp, $sk )
	{
		$params = array(
			'artist'    => $artist,
			'track'     => $track,
			'timestamp' => $timestamp,
			'sk'        => $sk,
		);

		$result = $this->post( self::PREFIX . 'removeScrobble', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/library.removeTrack
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $sk
	 * @return string
	 */
	public function removeTrack( $artist, $track, $sk )
	{
		$params = array(
			'artist' => $artist,
			'track'  => $track,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'removeTrack', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}
}
