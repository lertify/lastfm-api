<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Api\Data,
	Lertify\Lastfm\Api\Data\Album\Tag,
	Lertify\Lastfm\Api\Data\Album\Track,
	Lertify\Lastfm\Util\Util,
	InvalidArgumentException;

class Album extends AbstractApi
{
	const
		PREFIX = 'album.';

	/**
	 * @link http://www.last.fm/api/show/album.addTags
	 *
	 * @param string $artist
	 * @param string $album
	 * @param array $tags
	 * @param string $sk
	 * @throws \InvalidArgumentException
	 * @return \Lertify\Lastfm\Api\Data\PostResponse
	 */
	public function addTags( $artist, $album, array $tags, $sk )
	{
		if ( count( $tags ) > 10 )
		{
			throw new InvalidArgumentException( 'The allowed maximum is 10 tags per request' );
		}

		$params = array(
			'artist' => $artist,
			'album'  => $album,
			'tags'   => implode( ',', $tags ),
			'sk'     => $sk,
		);

		return $this->post( 'PostResponse', self::PREFIX . 'addTags', $params, array( 'is_signed' => true ) );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getBuylinks
	 *
	 * @param string $artist
	 * @param string $album
	 * @param string $country
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\Album\AffiliationsCollection
	 */
	public function getBuylinks( $artist, $album, $country = 'United Kingdom', $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'autocorrect' => $autocorrect,
			'country'     => $country,
		);

		return $this->get( 'Album\AffiliationsCollection', self::PREFIX . 'getBuylinks', $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getBuylinks
	 *
	 * @param string $mbId
	 * @param string $country
	 * @return \Lertify\Lastfm\Api\Data\Album\AffiliationsCollection
	 */
	public function getBuylinksByMbid( $mbId, $country = 'United States' )
	{
		$params = array(
			'mbid'    => $mbId,
			'country' => $country,
		);

		return $this->get( 'Album\AffiliationsCollection', self::PREFIX . 'getBuylinks', $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getInfo
	 *
	 * @param string $artist
	 * @param string $album
	 * @param bool $autocorrect
	 * @param string $username
	 * @param string|null $lang
	 * @return \Lertify\Lastfm\Api\Data\Album\Album
	 */
	public function getInfo( $artist, $album, $autocorrect = false, $username = '', $lang = null )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'autocorrect' => $autocorrect,
			'username'    => $username,
			'lang'        => $lang,
		);

		return $this->get( 'Album\Album', self::PREFIX . 'getInfo', $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getInfo
	 *
	 * @param string $mbId
	 * @param string $username
	 * @param string|null $lang
	 * @return \Lertify\Lastfm\Api\Data\Album\Album
	 */
	public function getInfoByMbid( $mbId, $username = '', $lang = null )
	{
		$params = array(
			'mbid'     => $mbId,
			'username' => $username,
			'lang'     => $lang,
		);

		return $this->get( 'Album\Album', self::PREFIX . 'getInfo', $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getShouts
	 *
	 * @param string $artist
	 * @param string $album
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getShouts( $artist, $album, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'autocorrect' => $autocorrect,
		);

		return $this->getShoutsPageCollection( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getShouts
	 *
	 * @param string $mbId
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getShoutsByMbid( $mbId )
	{
		$params = array(
			'mbid' => $mbId,
		);

		return $this->getShoutsPageCollection( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTags
	 *
	 * @param string $artist
	 * @param string $album
	 * @param string $username
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\Album\TagsCollection
	 */
	public function getTags( $artist, $album, $username, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'user'        => $username,
			'autocorrect' => $autocorrect,
		);

		return $this->get( 'Album\TagsCollection', self::PREFIX . 'getTags', $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTags
	 *
	 * @param string $artist
	 * @param string $album
	 * @param string $sk
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\Album\TagsCollection
	 */
	public function getTagsAuth( $artist, $album, $sk, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'sk'          => $sk,
			'autocorrect' => $autocorrect,
		);

		return $this->get( 'Album\TagsCollection', self::PREFIX . 'getTags', $params, array( 'is_signed' => true ) );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTags
	 *
	 * @param string $mbId
	 * @param string $username
	 * @return \Lertify\Lastfm\Api\Data\Album\TagsCollection
	 */
	public function getTagsByMbid( $mbId, $username )
	{
		$params = array(
			'mbid' => $mbId,
			'user' => $username,
		);

		return $this->get( 'Album\TagsCollection', self::PREFIX . 'getTags', $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTags
	 *
	 * @param string $mbId
	 * @param string $sk
	 * @return \Lertify\Lastfm\Api\Data\Album\TagsCollection
	 */
	public function getTagsByMbidAuth( $mbId, $sk )
	{
		$params = array(
			'mbid' => $mbId,
			'sk'   => $sk,
		);

		return $this->get( 'Album\TagsCollection', self::PREFIX . 'getTags', $params, array( 'is_signed' => true ) );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTopTags
	 *
	 * @param string $artist
	 * @param string $album
	 * @param bool $autocorrect
	 * @return \Lertify\Lastfm\Api\Data\Album\TopTagsCollection
	 */
	public function getTopTags( $artist, $album, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'autocorrect' => $autocorrect,
		);

		return $this->get( 'Album\TopTagsCollection', self::PREFIX . 'getTopTags', $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTopTags
	 *
	 * @param string $mbId
	 * @return \Lertify\Lastfm\Api\Data\Album\TagsCollection
	 */
	public function getTopTagsByMbid( $mbId )
	{
		$params = array(
			'mbid' => $mbId,
		);

		return $this->get( 'Album\TagsCollection', self::PREFIX . 'getTopTags', $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.removeTag
	 *
	 * @param string $artist
	 * @param string $album
	 * @param string $tag
	 * @param string $sk
	 * @return \Lertify\Lastfm\Api\Data\PostResponse
	 */
	public function removeTag( $artist, $album, $tag, $sk )
	{
		$params = array(
			'artist' => $artist,
			'album'  => $album,
			'tag'    => $tag,
			'sk'     => $sk,
		);

		return $this->post( 'PostResponse', self::PREFIX . 'removeTag', $params, array( 'is_signed' => true ) );
	}

	/**
	 * @link http://www.last.fm/api/show/album.search
	 *
	 * @param string $album
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function search( $album )
	{
		$params = array(
			'album' => $album,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Album */
			$result  = $self->get( Album::PREFIX . 'search', $params );
			$results = $result['results'];

			$totalResults = (int) $results['opensearch:totalResults'];
			$itemsPerPage = (int) $results['opensearch:itemsPerPage'];

			if ( empty( $results['albummatches'] ) )
			{
				return null;
			}

			if ( isset( $results['albummatches']['album'][0] ) )
			{
				$albumsList = $results['albummatches']['album'];
			}
			else
			{
				$albumsList = array( $results['albummatches']['album'] );
			}

			$Albums = new ArrayCollection();

			foreach ( $albumsList as $albumRow )
			{
				$Album = new Data\Album\Album();

				$Album->setId( (int) $albumRow['id'] );
				$Album->setName( Util::toSting( $albumRow['name'] ) );
				$Album->setArtist( Util::toSting( $albumRow['artist'] ) );
				$Album->setUrl( Util::toSting( $albumRow['url'] ) );
				$Album->setStreamable( (bool) ( (int) $albumRow['streamable'] ) );
				$Album->setMbid( Util::toSting( $albumRow['mbid'] ) );

				$Images = new ArrayCollection();

				foreach ( $albumRow['image'] as $image )
				{
					if ( '' === ( $imageUrl = trim( $image['#text'] ) ) )
					{
						continue;
					}

					$Images->set( Util::toSting( $image['size'] ), Util::toSting( $imageUrl ) );
				}

				$Album->setImages( $Images );

				$Albums->set( $Album->getId(), $Album );
			}

			return array(
				'results'       => $Albums,
				'total_pages'   => ceil( $totalResults / $itemsPerPage ),
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/album.share
	 *
	 * @param string $artist
	 * @param string $album
	 * @param string|array $recipient
	 * @param string $sk
	 * @param bool $public
	 * @param string|null $message
	 * @throws \InvalidArgumentException
	 * @return string
	 */
	public function share( $artist, $album, $recipient, $sk, $public = false, $message = null )
	{
		if ( is_array( $recipient ) )
		{
			if ( count( $recipient ) > 10 )
			{
				throw new InvalidArgumentException( 'The allowed maximum is 10 recipients per request' );
			}
		}
		else
		{
			$recipient = explode( ',', preg_replace( '#[\s]+#', '', $recipient ) );

			if ( count( $recipient ) > 10 )
			{
				throw new InvalidArgumentException( 'The allowed maximum is 10 recipients per request' );
			}
		}

		$recipient = implode( ',', $recipient );

		$params = array(
			'artist'    => $artist,
			'album'     => $album,
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
	 * @param array $params
	 * @return \Lertify\Lastfm\Api\Data\Album\Album
	 */
	private function fillAlbumInfo( array $params )
	{
		$result      = $this->get( self::PREFIX . 'getInfo', $params );
		$resultAlbum = $result['album'];

		$Album = new Data\Album\Album();

		$Album->setId( (int) $resultAlbum['id'] );
		$Album->setName( Util::toSting( $resultAlbum['name'] ) );
		$Album->setArtist( Util::toSting( $resultAlbum['artist'] ) );
		$Album->setUrl( Util::toSting( $resultAlbum['url'] ) );
		$Album->setMbid( Util::toSting( $resultAlbum['mbid'] ) );
		$Album->setReleaseDate( Util::toSting( $resultAlbum['releasedate'] ) );
		$Album->setListeners( (int) $resultAlbum['listeners'] );
		$Album->setPlaycount( (int) $resultAlbum['playcount'] );

		$Images = new ArrayCollection();

		foreach ( $resultAlbum['image'] as $image )
		{
			if ( '' === ( $imageUrl = Util::toSting( $image['#text'] ) ) )
			{
				continue;
			}

			$Images->set( Util::toSting( $image['size'] ), $imageUrl );
		}

		$Album->setImages( $Images );

		$this->addTracks( $Album, $resultAlbum['tracks'] );
		$this->addTopTags( $Album, $resultAlbum['toptags'] );
		$this->addBiography( $Album, isset( $resultAlbum['wiki'] ) ? $resultAlbum['wiki'] : array() );

		return $Album;
	}

	/**
	 * @param array $params
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	private function getShoutsPageCollection( array $params )
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			/** @var $List \Lertify\Lastfm\Api\Data\Album\ShoutsCollection */
			$List   = $self->get( 'Album\ShoutsCollection', \Lertify\Lastfm\Api\Album::PREFIX . 'getShouts', $params );

			return array(
				'results'       => $List,
				'total_pages'   => $List->getTotalPages(),
				'total_results' => $List->getTotal(),
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @param array $params
	 * @param array $options
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private function fetchTags( array $params, array $options = array() )
	{
		$result     = $this->get( self::PREFIX . 'getTags', $params, $options );
		$resultTags = $result['tags'];

		if ( isset( $resultTags['#text'] ) )
		{
			$artistName = Util::toSting( $resultTags['artist'] );
			$albumName  = Util::toSting( $resultTags['album'] );
		}
		else
		{
			$artistName = Util::toSting( $resultTags['@attr']['artist'] );
			$albumName  = Util::toSting( $resultTags['@attr']['album'] );
		}

		$List = new ArrayCollection();

		if ( ! isset( $resultTags['tag'] ) )
		{
			return $List;
		}

		if ( isset( $resultTags['tag'][0] ) )
		{
			$tags = $resultTags['tag'];
		}
		else
		{
			$tags = array( $resultTags['tag'] );
		}

		foreach ( $tags as $tagRow )
		{
			$Tag = new Tag();

			$Tag->setArtist( $artistName );
			$Tag->setAlbum( $albumName );
			$Tag->setName( Util::toSting( $tagRow['name'] ) );
			$Tag->setUrl( Util::toSting( $tagRow['url'] ) );

			$List->add( $Tag );
		}

		return $List;
	}

	/**
	 * @param array $params
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private function fetchTopTagCollection( array $params )
	{
		$result        = $this->get( self::PREFIX . 'getTopTags', $params );
		$resultTopTags = $result['toptags'];

		if ( isset( $resultTopTags['#text'] ) )
		{
			$artistName = Util::toSting( $resultTopTags['artist'] );
			$albumName  = Util::toSting( $resultTopTags['album'] );
		}
		else
		{
			$artistName = Util::toSting( $resultTopTags['@attr']['artist'] );
			$albumName  = Util::toSting( $resultTopTags['@attr']['album'] );
		}

		$TopTags = new ArrayCollection();

		if ( ! isset( $resultTopTags['tag'] ) )
		{
			return $TopTags;
		}

		if ( isset( $resultTopTags['tag'][0] ) )
		{
			$tags = $resultTopTags['tag'];
		}
		else
		{
			$tags = array( $resultTopTags['tag'] );
		}

		foreach ( $tags as $tagRow )
		{
			$Tag = new Tag();

			$Tag->setArtist( $artistName );
			$Tag->setAlbum( $albumName );
			$Tag->setName( Util::toSting( $tagRow['name'] ) );
			$Tag->setUrl( Util::toSting( $tagRow['url'] ) );
			$Tag->setCount( (int) $tagRow['count'] );

			$TopTags->add( $Tag );
		}

		return $TopTags;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album\Album $Album
	 * @param array $tracks
	 */
	private function addTracks( Data\Album\Album $Album, array $tracks )
	{
		$Tracks = new ArrayCollection();

		/** @var $TrackXml \SimpleXMLElement */
		foreach ( $tracks['track'] as $trackRow )
		{
			$Track = new Track();

			$Track->setRank( (int) $trackRow['@attr']['rank'] );
			$Track->setName( Util::toSting( $trackRow['name'] ) );
			$Track->setDuration( (int) $trackRow['duration'] );
			$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
			$Track->setUrl( Util::toSting( $trackRow['url'] ) );
			$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['fulltrack'] ) );
			$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );
			$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
			$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
			$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

			$Tracks->add( $Track );
		}

		$Album->setTracks( $Tracks );
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album\Album $Album
	 * @param array $topTags
	 */
	private function addTopTags( Data\Album\Album $Album, array $topTags )
	{
		$TopTags = new ArrayCollection();

		foreach ( $topTags['tag'] as $tagRow )
		{
			$Tag = new Tag();

			$Tag->setName( Util::toSting( $tagRow['name'] ) );
			$Tag->setUrl( Util::toSting( $tagRow['url'] ) );

			$TopTags->add( $Tag );
		}

		$Album->setTopTags( $TopTags );
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album\Album $Album
	 * @param array $wiki
	 */
	private function addBiography( Data\Album\Album $Album, array $wiki )
	{
		if ( ! empty( $wiki ) )
		{
			$Album->setWikiPublishedAt( Util::toSting( $wiki['published'] ) );
			$Album->setWikiSummary( Util::toSting( $wiki['summary'] ) );
			$Album->setWikiContent( Util::toSting( $wiki['content'] ) );
		}
	}
}
