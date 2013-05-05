<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\Track\Affiliation,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Util\Util,
	Lertify\Lastfm\Exception\NotFoundException,

	InvalidArgumentException;

class Track extends AbstractApi
{
	const
		PREFIX = 'track.';

	/**
	 * @link http://www.last.fm/api/show/track.addTags
	 *
	 * @param string $artist
	 * @param string $track
	 * @param array $tags
	 * @param string $sk
	 * @throws \InvalidArgumentException
	 * @return string
	 */
	public function addTags( $artist, $track, array $tags, $sk )
	{
		if ( count( $tags ) > 10 )
		{
			throw new InvalidArgumentException( 'The allowed maximum is 10 tags per request' );
		}

		$params = array(
			'artist' => $artist,
			'track'  => $track,
			'tags'   => implode( ',', $tags ),
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'addTags', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/track.ban
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $sk
	 * @return string
	 */
	public function ban( $artist, $track, $sk )
	{
		$params = array(
			'artist' => $artist,
			'track'  => $track,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'ban', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/track.getBuylinks
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $country
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getBuylinks( $artist, $track, $country = 'United Kingdom', $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'track'       => $track,
			'country'     => $country,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchBuylinks( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getBuylinks
	 *
	 * @param string $mbId
	 * @param string $country
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getBuylinksByMbid( $mbId, $country = 'United Kingdom' )
	{
		$params = array(
			'mbid'    => $mbId,
			'country' => $country,
		);

		return $this->fetchBuylinks( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getCorrection
	 *
	 * @param string $artist
	 * @param string $track
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\Track\Track
	 */
	public function getCorrection( $artist, $track )
	{
		$params = array(
			'artist' => $artist,
			'track'  => $track,
		);

		$result           = $this->get( self::PREFIX . 'getCorrection', $params );
		$resultCorrection = $result['corrections'];

		if ( ! is_array( $resultCorrection ) )
		{
			throw new NotFoundException( 'No track found!' );
		}

        $Track           = new Data\Track\Track();
		$trackCorrection = $resultCorrection['correction']['track'];

		$Track->setName( Util::toSting( $trackCorrection['name'] ) );
		$Track->setMbid( Util::toSting( $trackCorrection['mbid'] ) );
		$Track->setUrl( Util::toSting( $trackCorrection['url'] ) );

		$Track->setArtistName( Util::toSting( $trackCorrection['artist']['name'] ) );
		$Track->setArtistMbId( Util::toSting( $trackCorrection['artist']['mbid'] ) );
		$Track->setArtistUrl( Util::toSting( $trackCorrection['artist']['url'] ) );

		return $Track;
	}

	/**
	 * @link http://www.last.fm/api/show/track.getFingerprintMetadata
	 *
	 * @param int $fingerprintId
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getFingerprintMetadata( $fingerprintId )
	{
		$params = array(
			'fingerprintid' => $fingerprintId,
		);

		$result = $this->get( self::PREFIX . 'getFingerprintMetadata', $params );

		if ( isset( $result['tracks'] ) && empty( $result['tracks'] ) )
		{
			throw new NotFoundException( 'No tracks found with fingerprint: ' . $fingerprintId );
		}

		$List = new ArrayCollection();

		foreach ( $result['tracks']['track'] as $track )
		{
			$Track = new Data\Track\Track();

			$Track->setName( Util::toSting( $track['name'] ) );
			$Track->setDuration( (int) $track['duration'] );
			$Track->setMbId( Util::toSting( $track['mbid'] ) );
			$Track->setUrl( Util::toSting( $track['url'] ) );

			$Track->setStreamable( (bool) $track['streamable']['#text'] );
			$Track->setStreamableFulltrack( (bool) $track['streamable']['fulltrack'] );

			$Track->setRank( (float) $track['@attr']['rank'] );

			$Track->setArtistName( Util::toSting( $track['artist']['name'] ) );
			$Track->setArtistMbId( Util::toSting( $track['artist']['mbid'] ) );
			$Track->setArtistUrl( Util::toSting( $track['artist']['url'] ) );

			$TrackImages = new ArrayCollection();

			if ( isset( $track['image'] ) )
			{
				foreach ( $track['image'] as $image )
				{
					$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}
			}

			$Track->setImages( $TrackImages );

			$List->add( $Track );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/track.getInfo
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $username
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\Track\Track
	 */
	public function getInfo( $artist, $track, $username = '', $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'track'       => $track,
			'username'    => $username,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchInfo( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getInfo
	 *
	 * @param string $mbid
	 * @param string $username
	 * @return \Lertify\Lastfm\Api\Data\Track\Track
	 */
	public function getInfoByMbid( $mbid, $username = '' )
	{
		$params = array(
			'mbid'     => $mbid,
			'username' => $username,
		);

		return $this->fetchInfo( $params );
	}

	/**
	 * http://www.last.fm/api/show/track.getShouts
	 *
	 * @param string $artist
	 * @param string $track
	 * @param bool $autocorrect
	 * @param int $limit
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getShouts( $artist, $track, $autocorrect = false, $limit = 50 )
	{
		$params = array(
			'artist'      => $artist,
			'track'       => $track,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchShouts( $params, $limit );
	}

	/**
	 * http://www.last.fm/api/show/track.getShouts
	 *
	 * @param string $mbid
	 * @param int $limit
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getShoutsByMbid( $mbid, $limit = 50 )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchShouts( $params, $limit );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getSimilar
	 *
	 * @param string $artist
	 * @param string $track
	 * @param bool $autocorrect
	 * @param int $limit
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getSimilar( $artist, $track, $autocorrect = false, $limit = 50 )
	{
		$params = array(
			'artist'      => $artist,
			'track'       => $track,
			'autocorrect' => $autocorrect,
			'limit'       => $limit,
		);

		return $this->fetchSimilarTracks( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getSimilar
	 *
	 * @param string $mbid
	 * @param int $limit
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getSimilarByMbid( $mbid, $limit = 50 )
	{
		$params = array(
			'mbid'  => $mbid,
			'limit' => $limit,
		);

		return $this->fetchSimilarTracks( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getTags
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $username
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTags( $artist, $track, $username, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'track'       => $track,
			'user'        => $username,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchGetTags( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getTags
	 *
	 * @param string $mbid
	 * @param string $username
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTagsByMbid( $mbid, $username )
	{
		$params = array(
			'mbid' => $mbid,
			'user' => $username,
		);

		return $this->fetchGetTags( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getTopFans
	 *
	 * @param string $artist
	 * @param string $track
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTopFans( $artist, $track, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'track'       => $track,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchGetTopFans( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getTopFans
	 *
	 * @param string $mbid
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTopFansByMbid( $mbid )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchGetTopFans( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getTopTags
	 *
	 * @param string $artist
	 * @param string $track
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTopTags( $artist, $track, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'track'       => $track,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchGetTopTags( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.getTopTags
	 *
	 * @param string $mbid
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTopTagsByMbid( $mbid )
	{
		$params = array(
			'mbid' => $mbid,
		);

		return $this->fetchGetTopTags( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/track.love
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $sk
	 * @return string
	 */
	public function love( $artist, $track, $sk )
	{
		$params = array(
			'artist' => $artist,
			'track'  => $track,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'love', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/track.removeTag
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $tag
	 * @param string $sk
	 * @return string
	 */
	public function removeTag( $artist, $track, $tag, $sk )
	{
		$params = array(
			'artist' => $artist,
			'track'  => $track,
			'tag'    => $tag,
			'sk'     => $sk,
		);

		$result = $this->post( self::PREFIX . 'removeTag', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/track.scrobble
	 *
	 * @param array $scrobbledTracks
	 * @param string $sk
	 */
	public function scrobble( array $scrobbledTracks, $sk )
	{
		// @todo: Implement method
	}

	/**
	 * @link http://www.last.fm/api/show/track.search
	 *
	 * @param string $artist
	 * @param string $track
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function search( $artist, $track )
	{
		$params = array(
			'artist' => $artist,
			'track'  => $track,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result  = $self->get( Track::PREFIX . 'search', $params );
			$results = $result['results'];

			$totalResults = (int) $results['opensearch:totalResults'];
			$itemsPerPage = (int) $results['opensearch:itemsPerPage'];

			if ( empty( $results['trackmatches'] ) )
			{
				throw new NotFoundException( 'No tracks found!' );
			}

			if ( isset( $results['trackmatches']['track'][0] ) && is_array( $results['trackmatches']['track'][0] ) )
			{
				$trackList = $results['trackmatches']['track'];
			}
			else
			{
				$trackList = array( $results['trackmatches']['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $trackList as $trackRow )
			{
				$Track = new Data\Track\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setArtistName( Util::toSting( $trackRow['artist'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );

				$Track->setStreamable( (bool) $trackRow['streamable']['#text'] );
				$Track->setStreamableFulltrack( (bool) $trackRow['streamable']['fulltrack'] );

				$Track->setListeners( (int) $trackRow['listeners'] );

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
				'total_pages'   => ceil( $totalResults / $itemsPerPage ),
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/track.share
	 *
	 * @param string $artist
	 * @param string $track
	 * @param array|string $recipient
	 * @param string $sk
	 * @param bool $public
	 * @param string|null $message
	 * @throws \InvalidArgumentException
	 * @return string
	 */
	public function share( $artist, $track, $recipient, $sk, $public = false, $message = null )
	{
		if ( is_string( $recipient ) )
		{
			$recipient = explode( ',', preg_replace( '#[\s]+#', '', $recipient ) );
		}

		if ( count( $recipient ) > 10 )
		{
			throw new InvalidArgumentException( 'The allowed maximum is 10 recipients per request' );
		}

		$recipient = implode( ',', $recipient );

		$params = array(
			'artist'    => $artist,
			'track'     => $track,
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
	 * @link http://www.last.fm/api/show/track.unban
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $sk
	 * @return string
	 */
	public function unban( $artist, $track, $sk )
	{
		$params = array(
			'artist'    => $artist,
			'track'     => $track,
			'sk'        => $sk,
		);

		$result = $this->post( self::PREFIX . 'unban', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/track.unlove
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $sk
	 * @return string
	 */
	public function unlove( $artist, $track, $sk )
	{
		$params = array(
			'artist'    => $artist,
			'track'     => $track,
			'sk'        => $sk,
		);

		$result = $this->post( self::PREFIX . 'unlove', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/track.updateNowPlaying
	 *
	 * @param string $artist
	 * @param string $track
	 * @param string $sk
	 * @param string $album
	 * @param string $trackNumber
	 * @param string $context
	 * @param string $mbid
	 * @param int $duration // in seconds
	 * @param string $albumArtist // if this differs from the track artist
	 */
	public function updateNowPlaying( $artist, $track, $sk, $album = '', $trackNumber = '', $context = '', $mbid = '', $duration = 0, $albumArtist = '' )
	{
		$params = array(
			'artist'      => $artist,
			'track'       => $track,
			'sk'          => $sk,
			'album'       => $album,
			'trackNumber' => $trackNumber,
			'context'     => $context,
			'mbid'        => $mbid,
			'duration'    => $duration,
			'albumArtist' => $albumArtist,
		);

		$this->post( self::PREFIX . 'updateNowPlaying', $params, array( 'is_signed' => true ) );
	}

	/**
	 * @param array $params
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private function fetchBuylinks( array $params )
	{
		$result = $this->get( self::PREFIX . 'getBuylinks', $params );

		$PhysicalsList = new ArrayCollection();

		if ( ! isset( $result['affiliations'] ) )
		{
			return new ArrayCollection();
		}

		if ( isset( $result['affiliations']['physicals']['affiliation'][0] ) )
		{
			$physicalsAffiliations = $result['affiliations']['physicals']['affiliation'];
		}
		else
		{
			$physicalsAffiliations = array( $result['affiliations']['physicals']['affiliation'] );
		}

		foreach ( $physicalsAffiliations as $affiliationRow )
		{
			$Affiliation = new Affiliation();

			$Affiliation->setSupplierName( Util::toSting( $affiliationRow['supplierName'] ) );

			if ( isset( $affiliationRow['price'] ) )
			{
				$Affiliation->setPriceCurrency( Util::toSting( $affiliationRow['price']['currency'] ) );
				$Affiliation->setPriceAmount( Util::toSting( $affiliationRow['price']['amount'] ) );
			}

			$Affiliation->setBuyLink( Util::toSting( $affiliationRow['buyLink'] ) );
			$Affiliation->setSupplierIcon( Util::toSting( $affiliationRow['supplierIcon'] ) );
			$Affiliation->setIsSearch( (bool) ( (int) $affiliationRow['isSearch'] ) );

			$PhysicalsList->add( $Affiliation );
		}

		$DownloadsList = new ArrayCollection();

		if ( isset( $result['affiliations']['downloads']['affiliation'][0] ) )
		{
			$downloadsAffiliations = $result['affiliations']['downloads']['affiliation'];
		}
		else
		{
			$downloadsAffiliations = array( $result['affiliations']['downloads']['affiliation'] );
		}

		foreach ( $downloadsAffiliations as $affiliationRow )
		{
			$Affiliation = new Affiliation();

			$Affiliation->setSupplierName( Util::toSting( $affiliationRow['supplierName'] ) );

			if ( isset( $affiliationRow['price'] ) )
			{
				$Affiliation->setPriceCurrency( Util::toSting( $affiliationRow['price']['currency'] ) );
				$Affiliation->setPriceAmount( Util::toSting( $affiliationRow['price']['amount'] ) );
			}

			$Affiliation->setBuyLink( Util::toSting( $affiliationRow['buyLink'] ) );
			$Affiliation->setSupplierIcon( Util::toSting( $affiliationRow['supplierIcon'] ) );
			$Affiliation->setIsSearch( (bool) ( (int) $affiliationRow['isSearch'] ) );

			$DownloadsList->add( $Affiliation );
		}

		$List = new ArrayCollection();

		$List->set( 'physicals', $PhysicalsList );
		$List->set( 'downloads', $DownloadsList );

		return $List;
	}

	/**
	 * @param array $params
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\Track\Track
	 */
	private function fetchInfo( array $params )
	{
		$result = $this->get( self::PREFIX . 'getInfo', $params );

		if ( isset( $result['track'] ) && empty( $result['track'] ) )
		{
			throw new NotFoundException( 'No track found!' );
		}

		$Track       = new Data\Track\Track();
		$trackRecord = $result['track'];

		$Track->setId( (int) $trackRecord['id'] );
		$Track->setName( Util::toSting( $trackRecord['name'] ) );
		$Track->setMbId( Util::toSting( $trackRecord['mbid'] ) );
		$Track->setUrl( Util::toSting( $trackRecord['url'] ) );
		$Track->setDuration( (int) $trackRecord['duration'] );

		$streamableInfo = $trackRecord['streamable'];

		$Track->setStreamable( (bool) $streamableInfo['#text'] );
		$Track->setStreamableFulltrack( (bool) $streamableInfo['fulltrack'] );

		$Track->setListeners( (int) $trackRecord['listeners'] );
		$Track->setPlaycount( (int) $trackRecord['playcount'] );

		$artistInfo = $trackRecord['artist'];

		$Track->setArtistName( Util::toSting( $artistInfo['name'] ) );
		$Track->setArtistMbId( Util::toSting( $artistInfo['mbid'] ) );
		$Track->setArtistUrl( Util::toSting( $artistInfo['url'] ) );

		$albumInfo = $trackRecord['album'];
		$Album     = new Data\Track\Album();

		$Album->setName( Util::toSting( $albumInfo['title'] ) );
		$Album->setArtist( Util::toSting( $albumInfo['artist'] ) );
		$Album->setMbid( Util::toSting( $albumInfo['mbid'] ) );
		$Album->setUrl( Util::toSting( $albumInfo['url'] ) );

		$AlbumImages = new ArrayCollection();

		if ( isset( $albumInfo['image'] ) && ! empty( $albumInfo['image'] ) )
		{
			foreach ( $albumInfo['image'] as $image )
			{
				$AlbumImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
			}
		}

		$Album->setImages( $AlbumImages );
		$Album->setPosition( $albumInfo['@attr']['position'] );
		$Track->setAlbum( $Album );

		$TopTags = new ArrayCollection();

		if ( isset( $trackRecord['toptags']['tag'] ) && ! empty( $trackRecord['toptags']['tag'] ) )
		{
			foreach ( $trackRecord['toptags']['tag'] as $tagRecord )
			{
				$Tag = new Data\Track\Tag();

				$Tag->setName( Util::toSting( $tagRecord['name'] ) );
				$Tag->setUrl( Util::toSting( $tagRecord['url'] ) );

				$TopTags->add( $Tag );
			}
		}

		$Track->setTopTags( $TopTags );

		if ( isset( $trackRecord['wiki'] ) && ! empty( $trackRecord['wiki'] ) )
		{
			$wikiInfo = $trackRecord['wiki'];

			$Track->setWikiPublishedAt( Util::toSting( $wikiInfo['published'] ) );
			$Track->setWikiSummary( Util::toSting( $wikiInfo['summary'] ) );
			$Track->setWikiContent( Util::toSting( $wikiInfo['content'] ) );
		}

		return $Track;
	}

	/**
	 * @param array $params
	 * @param int $limit
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	private function fetchShouts( array $params, $limit )
	{
		/** @var $self \Lertify\Lastfm\Api\Track */
		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params       = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result       = $self->get( Track::PREFIX . 'getShouts', $params );
			$resultShouts = $result['shouts'];

			if ( ! isset( $resultShouts['shout'] ) )
			{
				throw new NotFoundException( 'There are no shouts for this atrist and track!' );
			}

			if ( isset( $resultShouts['shout'][0] ) )
			{
				$shouts = $resultShouts['shout'];
			}
			else
			{
				$shouts = array( $resultShouts['shout'] );
			}

			$totalResults = (int) $resultShouts['@attr']['total'];
			$totalPages   = (int) $resultShouts['@attr']['totalPages'];

			$List = new ArrayCollection();

			foreach ( $shouts as $shoutRow )
			{
				$Shout = new Data\Track\Shout();

				$Shout->setArtist( Util::toSting( $resultShouts['@attr']['artist'] ) );
				$Shout->setTrack( Util::toSting( $resultShouts['@attr']['track'] ) );
				$Shout->setBody( Util::toSting( $shoutRow['body'] ) );
				$Shout->setAuthor( Util::toSting( $shoutRow['author'] ) );
				$Shout->setDate( Util::toSting( $shoutRow['date'] ) );

				$List->add( $Shout );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $totalResults,
			);
		};

		$PagedCollection = new PagedCollection( $resultCallback );
		$PagedCollection->setLimit( $limit );

		return $PagedCollection;
	}

	/**
	 * @param array $params
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 *
	 */
	private function fetchSimilarTracks( array $params )
	{
		$result              = $this->get( self::PREFIX . 'getSimilar', $params );
		$resultSimilartracks = $result['similartracks'];

		if ( ! isset( $resultSimilartracks['track'] ) )
		{
			throw new NotFoundException( 'There are no similar tracks for this atrist and track!' );
		}

		if ( isset( $resultSimilartracks['track'][0] ) && is_array( $resultSimilartracks['track'][0] ) )
		{
			$similarTracks = $resultSimilartracks['track'];
		}
		else
		{
			$similarTracks = array( $resultSimilartracks['track'] );
		}

		$List = new ArrayCollection();

		foreach ( $similarTracks as $similarTrack )
		{
			$Track = new Data\Track\Track();

			$Track->setName( Util::toSting( $similarTrack['name'] ) );
			$Track->setPlaycount( (int) $similarTrack['playcount'] );
			$Track->setMbId( Util::toSting( $similarTrack['mbid'] ) );
			$Track->setMatch( (float) $similarTrack['match'] );
			$Track->setUrl( Util::toSting( $similarTrack['url'] ) );

			$Track->setStreamable( (bool) $similarTrack['streamable']['#text'] );
			$Track->setStreamableFulltrack( (bool) $similarTrack['streamable']['fulltrack'] );

			$Track->setDuration( (int) $similarTrack['duration'] );

			$Track->setArtistName( Util::toSting( $similarTrack['artist']['name'] ) );
			$Track->setArtistMbId( Util::toSting( $similarTrack['artist']['mbid'] ) );
			$Track->setArtistUrl( Util::toSting( $similarTrack['artist']['url'] ) );

			$ImagesList = new ArrayCollection();

			if ( isset( $similarTrack['image'] ) )
			{
				foreach ( $similarTrack['image'] as $image )
				{
					$ImagesList->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}
			}

			$Track->setImages( $ImagesList );

			$List->add( $Track );
		}

		return $List;
	}

	/**
	 * @param array $params
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private function fetchGetTags( array $params )
	{
		$result     = $this->get( self::PREFIX . 'getTags', $params );
		$resultTags = $result['tags'];

		if ( ! isset( $resultTags['tag'] ) )
		{
			throw new NotFoundException( 'There are no tags for this atrist, track and user!' );
		}

		if ( isset( $resultTags['tag'][0] ) && is_array( $resultTags['tag'][0] ) )
		{
			$tags = $resultTags['tag'];
		}
		else
		{
			$tags = array( $resultTags['tag'] );
		}

		$List = new ArrayCollection();

		foreach ( $tags as $tagRecord )
		{
			$Tag = new Data\Track\Tag();

			$Tag->setArtist( Util::toSting( $resultTags['@attr']['artist'] ) );
			$Tag->setTrack( Util::toSting( $resultTags['@attr']['track'] ) );
			$Tag->setName( Util::toSting( $tagRecord['name'] ) );
			$Tag->setUrl( Util::toSting( $tagRecord['url'] ) );

			$List->add( $Tag );
		}

		return $List;
	}

	/**
	 * @param array $params
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private function fetchGetTopFans( array $params )
	{
		$result        = $this->get( self::PREFIX . 'getTopFans', $params );
		$resultTopFans = $result['topfans'];

		if ( ! isset( $resultTopFans['user'] ) )
		{
			throw new NotFoundException( 'There are no top fans for this atrist and track!' );
		}

		if ( isset( $resultTopFans['user'][0] ) && is_array( $resultTopFans['user'][0] ) )
		{
			$topFans = $resultTopFans['user'];
		}
		else
		{
			$topFans = array( $resultTopFans['user'] );
		}

		$List = new ArrayCollection();

		foreach ( $topFans as $topFanRecord )
		{
			$Topfan = new Data\Track\User();

			$Topfan->setName( Util::toSting( $topFanRecord['name'] ) );
			$Topfan->setRealName( Util::toSting( $topFanRecord['realname'] ) );
			$Topfan->setUrl( Util::toSting( $topFanRecord['url'] ) );

			$TopfanImages = new ArrayCollection();

			if ( isset( $topFanRecord['image'] ) )
			{
				foreach ( $topFanRecord['image'] as $image )
				{
					$TopfanImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}
			}

			$Topfan->setImages( $TopfanImages );

			$List->add( $Topfan );
		}

		return $List;
	}

	/**
	 * @param array $params
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private function fetchGetTopTags( array $params )
	{
		$result        = $this->get( self::PREFIX . 'getTopTags', $params );
		$resultTopTags = $result['toptags'];

		if ( ! isset( $resultTopTags['tag'] ) )
		{
			throw new NotFoundException( 'There are no top tags for this atrist and track!' );
		}

		if ( isset( $resultTopTags['tag'][0] ) && is_array( $resultTopTags['tag'][0] ) )
		{
			$topTags = $resultTopTags['tag'];
		}
		else
		{
			$topTags = array( $resultTopTags['tag'] );
		}

		$List = new ArrayCollection();

		foreach ( $topTags as $topTagRecord )
		{
			$Toptag = new Data\Track\Tag();

			$Toptag->setName( Util::toSting( $topTagRecord['name'] ) );
			$Toptag->setCount( (int) $topTagRecord['count'] );
			$Toptag->setUrl( Util::toSting( $topTagRecord['url'] ) );

			$List->add( $Toptag );
		}

		return $List;
	}
}