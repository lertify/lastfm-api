<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Api\Data,
	Lertify\Lastfm\Api\Data\Album\Shout,
	Lertify\Lastfm\Api\Data\Album\Affiliation,
	Lertify\Lastfm\Api\Data\Album\Tag,
	Lertify\Lastfm\Api\Data\Album\Track,
	Lertify\Lastfm\Util\Util,
	Lertify\Lastfm\Exception\PageNotFoundException,
	Lertify\Lastfm\Exception\NotFoundException;

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
	 */
	public function addTags( $artist, $album, array $tags )
	{
		// @todo No implemenration due to problem with authentication
	}

	/**
	 * @link http://www.last.fm/api/show/album.getBuylinks
	 *
	 * @param string $artist
	 * @param string $album
	 * @param string $country
	 * @param bool $autocorrect
	 * @return ArrayCollection
	 */
	public function getBuylinks( $artist, $album, $country = 'United Kingdom', $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'autocorrect' => $autocorrect,
			'country'     => $country,
		);

		return $this->fetchBuylinks( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getBuylinks
	 *
	 * @param string $mbId
	 * @param string $country
	 * @return ArrayCollection
	 */
	public function getBuylinksByMbid( $mbId, $country = 'United States' )
	{
		$params = array(
			'mbid'    => $mbId,
			'country' => $country,
		);

		return $this->fetchBuylinks( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getInfo
	 *
	 * @param string $artist
	 * @param string $album
	 * @param bool $autocorrect
	 * @param string $username
	 * @param string|null $lang
	 * @return Data\Album\Album
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

		return $this->fillAlbumInfo( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getInfo
	 *
	 * @param string $mbId
	 * @param string $username
	 * @param string|null $lang
	 * @return Data\Album\Album
	 */
	public function getInfoByMbid( $mbId, $username = '', $lang = null )
	{
		$params = array(
			'mbid'     => $mbId,
			'username' => $username,
			'lang'     => $lang,
		);

		return $this->fillAlbumInfo( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getShouts
	 *
	 * @param string $artist
	 * @param string $album
	 * @param bool $autocorrect
	 * @return PagedCollection
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
	 * @return PagedCollection
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
	 * @return ArrayCollection
	 */
	public function getTags( $artist, $album, $username, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'user'        => $username,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTags( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTags
	 */
	public function getTagsAuth( $artist, $album, $autocorrect = false )
	{
		// @todo No implemenration due to problem with authentication
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTags
	 *
	 * @param string $mbId
	 * @param string $username
	 * @return ArrayCollection
	 */
	public function getTagsByMbid( $mbId, $username )
	{
		$params = array(
			'mbid' => $mbId,
			'user' => $username,
		);

		return $this->fetchTags( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTags
	 */
	public function getTagsByMbidAuth( $mbId )
	{
		// @todo No implemenration due to problem with authentication
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTopTags
	 *
	 * @param string $artist
	 * @param string $album
	 * @param bool $autocorrect
	 * @return ArrayCollection
	 */
	public function getTopTags( $artist, $album, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artist,
			'album'       => $album,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTopTagCollection( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.getTopTags
	 *
	 * @param string $mbId
	 * @return ArrayCollection
	 */
	public function getTopTagsByMbid( $mbId )
	{
		$params = array(
			'mbid' => $mbId,
		);

		return $this->fetchTopTagCollection( $params );
	}

	/**
	 * @link http://www.last.fm/api/show/album.removeTag
	 */
	public function removeTag( $artist, $album, $tag )
	{
		// @todo No implemenration due to problem with authentication
	}

	/**
	 * @link http://www.last.fm/api/show/album.search
	 *
	 * @param string $album
	 * @throws PageNotFoundException
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function search( $album )
	{
		$self   = $this;
		$params = array(
			'album' => $album,
		);

		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Album */
			$result = $self->get( Album::PREFIX . 'search', $params );

			/** @var $Xml \SimpleXMLElement */
			$Xml = simplexml_load_string( trim( $result ) );

			if ( ! $Xml )
			{
				throw new PageNotFoundException( 'No response or incorrect response received!' );
			}

			if ( isset( $Xml->error ) )
			{
				throw new NotFoundException( Util::toSting( $Xml->error ), (int) $Xml->error['code'] );
			}

			$Xml->registerXPathNamespace( 'opensearch', 'http://a9.com/-/spec/opensearch/1.1/' );

			$totalResults = (int) current( $Xml->xpath( '//opensearch:totalResults' ) );
			$itemsPerPage = (int) current( $Xml->xpath( '//opensearch:itemsPerPage' ) );

			if ( ! isset( $Xml->results->albummatches->album ) )
			{
				return null;
			}

			$Albums = new ArrayCollection();

			foreach ( $Xml->results->albummatches->album as $AlbumXml )
			{
				$Album = new Data\Album\Album();

				$Album->setId( (int) $AlbumXml->id );
				$Album->setName( Util::toSting( $AlbumXml->name ) );
				$Album->setArtist( Util::toSting( $AlbumXml->artist ) );
				$Album->setUrl( Util::toSting( $AlbumXml->url ) );
				$Album->setStreamable( (bool) ( (int) $AlbumXml->streamable ) );
				$Album->setMbid( Util::toSting( $AlbumXml->mbid ) );

				$Images = new ArrayCollection();

				foreach ( $AlbumXml->image as $image )
				{
					if ( '' === ( $imageUrl = trim( $image ) ) )
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
	 */
	public function share( $artist, $album, $recipient, $public = false, $message = null )
	{
		// @todo No implemenration due to problem with authentication
	}

	/**
	 * @param array $params
	 * @throws PageNotFoundException
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	private function fetchBuylinks( array $params )
	{
		$result = $this->get( self::PREFIX . 'getBuylinks', $params );

		/** @var $Xml \SimpleXMLElement */
		$Xml = simplexml_load_string( trim( $result ) );

		if ( ! $Xml )
		{
			throw new PageNotFoundException( 'No response or incorrect response received!' );
		}

		if ( isset( $Xml->error ) )
		{
			throw new NotFoundException( Util::toSting( $Xml->error ), (int) $Xml->error['code'] );
		}

		$PhysicalsList = new ArrayCollection();

		foreach ( $Xml->affiliations->physicals->affiliation as $AffiliationXml )
		{
			$Affiliation = new Affiliation();

			$Affiliation->setSupplierName( Util::toSting( $AffiliationXml->supplierName ) );

			if ( $AffiliationXml->price )
			{
				$Affiliation->setPriceCurrency( Util::toSting( $AffiliationXml->price[0]->currency ) );
				$Affiliation->setPriceAmount( Util::toSting( $AffiliationXml->price[0]->amount ) );
			}

			$Affiliation->setBuyLink( Util::toSting( $AffiliationXml->buyLink ) );
			$Affiliation->setSupplierIcon( Util::toSting( $AffiliationXml->supplierIcon ) );
			$Affiliation->setIsSearch( (bool) ( (int) $AffiliationXml->isSearch ) );

			$PhysicalsList->add( $Affiliation );
		}

		$DownloadsList = new ArrayCollection();

		foreach ( $Xml->affiliations->downloads->affiliation as $DownloadsXml )
		{
			$Affiliation = new Affiliation();

			$Affiliation->setSupplierName( Util::toSting( $DownloadsXml->supplierName ) );

			if ( $DownloadsXml->price )
			{
				$Affiliation->setPriceCurrency( Util::toSting( $DownloadsXml->price[0]->currency ) );
				$Affiliation->setPriceAmount( Util::toSting( $DownloadsXml->price[0]->amount ) );
			}

			$Affiliation->setBuyLink( Util::toSting( $DownloadsXml->buyLink ) );
			$Affiliation->setSupplierIcon( Util::toSting( $DownloadsXml->supplierIcon ) );
			$Affiliation->setIsSearch( (bool) ( (int) $DownloadsXml->isSearch ) );

			$DownloadsList->add( $Affiliation );
		}

		$List = new ArrayCollection();

		$List->set( 'physicals', $PhysicalsList );
		$List->set( 'downloads', $DownloadsList );

		return $List;
	}

	/**
	 * @param array $params
	 * @throws PageNotFoundException
	 * @throws NotFoundException
	 * @return Data\Album\Album
	 */
	private function fillAlbumInfo( array $params )
	{
		$result = $this->get( self::PREFIX . 'getInfo', $params );

		/** @var $Xml \SimpleXMLElement */
		$Xml = simplexml_load_string( trim( $result ) );

		if ( ! $Xml )
		{
			throw new PageNotFoundException( 'No response or incorrect response received!' );
		}

		if ( isset( $Xml->error ) )
		{
			throw new NotFoundException( Util::toSting( $Xml->error ), (int) $Xml->error['code'] );
		}

		$Album = new Data\Album\Album();

		$Album->setId( (int) $Xml->album->id );
		$Album->setName( Util::toSting( $Xml->album->name ) );
		$Album->setArtist( Util::toSting( $Xml->album->artist ) );
		$Album->setUrl( Util::toSting( $Xml->album->url ) );
		$Album->setMbid( Util::toSting( $Xml->album->mbid ) );
		$Album->setReleaseDate( Util::toSting( $Xml->album->releasedate ) );
		$Album->setListeners( (int) $Xml->album->listeners );
		$Album->setPlaycount( (int) $Xml->album->playcount );

		$Images = new ArrayCollection();

		foreach ( $Xml->album->image as $image )
		{
			if ( '' === ( $imageUrl = Util::toSting( $image ) ) )
			{
				continue;
			}

			$Images->set( Util::toSting( $image['size'] ), $imageUrl );
		}

		$Album->setImages( $Images );

		$this->addTracks( $Album, $Xml->album->tracks );
		$this->addTopTags( $Album, $Xml->album->toptags );
		$this->addBiography( $Album, $Xml->album->wiki );

		return $Album;
	}

	/**
	 * @param array $params
	 * @throws PageNotFoundException
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	private function getShoutsPageCollection( array $params )
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			/** @var $self Album */
			$result = $self->get( Album::PREFIX . 'getShouts', $params );

			/** @var $Xml \SimpleXMLElement */
			$Xml = simplexml_load_string( trim( $result ) );

			if ( ! $Xml )
			{
				throw new PageNotFoundException( 'No response or incorrect response received!' );
			}

			if ( isset( $Xml->error ) )
			{
				throw new NotFoundException( Util::toSting( $Xml->error ), (int) $Xml->error['code'] );
			}

			$totalPages = (int) $Xml->shouts['totalPages'];
			$total      = (int) $Xml->shouts['total'];

			$List = new ArrayCollection();

			/** @var $ShoutXml \SimpleXmlElement */
			foreach ( $Xml->shouts->shout as $ShoutXml )
			{
				$Shout = new Shout();

				$Shout->setArtist( Util::toSting( $Xml->shouts['artist'] ) );
				$Shout->setAlbum( Util::toSting( $Xml->shouts['album'] ) );
				$Shout->setBody( Util::toSting( $ShoutXml->body ) );
				$Shout->setAuthor( Util::toSting( $ShoutXml->author ) );
				$Shout->setDate( Util::toSting( $ShoutXml->date ) );

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
	 * @param array $params
	 * @throws PageNotFoundException
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	private function fetchTags( array $params )
	{
		$result = $this->get( self::PREFIX . 'getTags', $params );

		/** @var $Xml \SimpleXMLElement */
		$Xml = simplexml_load_string( trim( $result ) );

		if ( ! $Xml )
		{
			throw new PageNotFoundException( 'No response or incorrect response received!' );
		}

		if ( isset( $Xml->error ) )
		{
			throw new NotFoundException( Util::toSting( $Xml->error ), (int) $Xml->error['code'] );
		}

		$artistName = Util::toSting( $Xml->tags['artist'] );
		$albumName  = Util::toSting( $Xml->tags['album'] );

		$List = new ArrayCollection();

		if ( empty( $Xml->tags ) )
		{
			return $List;
		}

		foreach ( $Xml->tags->tag as $TagXml )
		{
			$Tag = new Tag();

			$Tag->setArtist( $artistName );
			$Tag->setAlbum( $albumName );
			$Tag->setName( Util::toSting( $TagXml->name ) );
			$Tag->setUrl( Util::toSting( $TagXml->url ) );

			$List->add( $Tag );
		}

		return $List;
	}

	/**
	 * @param array $params
	 * @throws PageNotFoundException
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	private function fetchTopTagCollection( array $params )
	{
		$result = $this->getClient()->get( self::PREFIX . 'getTopTags', $params );

		/** @var $Xml \SimpleXMLElement */
		$Xml = simplexml_load_string( trim( $result ) );

		if ( ! $Xml )
		{
			throw new PageNotFoundException( 'No response or incorrect response received!' );
		}

		if ( isset( $Xml->error ) )
		{
			throw new NotFoundException( Util::toSting( $Xml->error ), (int) $Xml->error['code'] );
		}

		$artistName = Util::toSting( $Xml->toptags['artist'] );
		$albumName  = Util::toSting( $Xml->toptags['album'] );

		$TopTags = new ArrayCollection();

		foreach ( $Xml->toptags->tag as $TagXml )
		{
			$Tag = new Tag();

			$Tag->setArtist( $artistName );
			$Tag->setAlbum( $albumName );
			$Tag->setName( Util::toSting( $TagXml->name ) );
			$Tag->setUrl( Util::toSting( $TagXml->url ) );
			$Tag->setCount( (int) $TagXml->count );

			$TopTags->add( $Tag );
		}

		return $TopTags;
	}

	/**
	 * @param Data\Album\Album $Album
	 * @param \SimpleXMLElement $TracksXml
	 */
	private function addTracks( Data\Album\Album $Album, \SimpleXMLElement $TracksXml )
	{
		$Tracks = new ArrayCollection();

		/** @var $TrackXml \SimpleXMLElement */
		foreach ( $TracksXml->track as $TrackXml )
		{
			$Track = new Track();

			$Track->setRank( (int) $TrackXml['rank'] );
			$Track->setName( Util::toSting( $TrackXml->name ) );
			$Track->setDuration( (int) $TrackXml->duration );
			$Track->setMbId( Util::toSting( $TrackXml->mbid ) );
			$Track->setUrl( Util::toSting( $TrackXml->url ) );
			$Track->setStreamableFulltrack( (bool) ( (int) $TrackXml->streamable['fulltrack'] ) );
			$Track->setStreamable( (bool) ( (int) $TrackXml->streamable ) );
			$Track->setArtistName( Util::toSting( $TrackXml->artist->name ) );
			$Track->setArtistMbId( Util::toSting( $TrackXml->artist->mbid ) );
			$Track->setArtistUrl( Util::toSting( $TrackXml->artist->url ) );

			$Tracks->add( $Track );
		}

		$Album->setTracks( $Tracks );
	}

	/**
	 * @param Data\Album\Album $Album
	 * @param \SimpleXMLElement $TopTagsXml
	 */
	private function addTopTags( Data\Album\Album $Album, \SimpleXMLElement $TopTagsXml )
	{
		$TopTags = new ArrayCollection();

		/** @var $TagXml \SimpleXMLElement */
		foreach ( $TopTagsXml->tag as $TagXml )
		{
			$Tag = new Tag();

			$Tag->setName( Util::toSting( $TagXml->name ) );
			$Tag->setUrl( Util::toSting( $TagXml->url ) );

			$TopTags->add( $Tag );
		}

		$Album->setTopTags( $TopTags );
	}

	/**
	 * @param Data\Album\Album $Album
	 * @param \SimpleXMLElement $Wiki
	 */
	private function addBiography( Data\Album\Album $Album, \SimpleXMLElement $Wiki )
	{
		$Album->setWikiPublishedAt( Util::toSting( $Wiki->published ) );
		$Album->setWikiSummary( Util::toSting( $Wiki->summary ) );
		$Album->setWikiContent( Util::toSting( $Wiki->content ) );
	}
}
