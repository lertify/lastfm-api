<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data,
Lertify\Lastfm\Util\Util;

class Album extends AbstractApi
{
	const
		PREFIX = 'album.';

	public function addTags()
	{
		// @todo Need to implement
	}

	public function getBuylinks( $artistName, $albumName, $autocorrect = false, $country = 'United States' )
	{
		// @todo Need to implement
	}

	public function getBuylinksByMbid( $mbId, $country = 'United States' )
	{
		// @todo Need to implement
	}

	/**
	 * @param string $artistName
	 * @param string $albumName
	 * @param bool $autocorrect
	 * @param string $username
	 * @param string|null $lang
	 * @return Data\Album\Album
	 */
	public function getInfo( $artistName, $albumName, $autocorrect = false, $username = '', $lang = null )
	{
		$params = array(
			'artist'      => $artistName,
			'album'       => $albumName,
			'autocorrect' => $autocorrect,
			'username'    => $username,
			'lang'        => $lang,
		);

		$result = $this->getClient()->get( self::PREFIX . 'getInfo', $params );

		/** @var $AlbumXml \SimpleXMLElement */
		$Xml = simplexml_load_string( trim( $result ) );

		return $this->fillAlbumInfo( $Xml->album );
	}

	/**
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

		$result = $this->getClient()->get( self::PREFIX . 'getInfo', $params );

		/** @var $AlbumXml \SimpleXMLElement */
		$Xml = simplexml_load_string( trim( $result ) );

		return $this->fillAlbumInfo( $Xml->album );
	}

	/**
	 * @param \SimpleXMLElement $AlbumXml
	 * @return Data\Album\Album
	 */
	private function fillAlbumInfo( \SimpleXMLElement $AlbumXml )
	{
		$Album = new Data\Album\Album();

		$Album->setId( (int) $AlbumXml->id );
		$Album->setName( Util::toSting( $AlbumXml->name ) );
		$Album->setArtist( Util::toSting( $AlbumXml->artist ) );
		$Album->setUrl( Util::toSting( $AlbumXml->url ) );
		$Album->setMbid( Util::toSting( $AlbumXml->mbid ) );
		$Album->setReleaseDate( Util::toSting( $AlbumXml->releasedate ) );
		$Album->setListeners( (int) $AlbumXml->listeners );
		$Album->setPlaycount( (int) $AlbumXml->playcount );

		foreach ( $AlbumXml->image as $image )
		{
			if ( '' === ( $imageUrl = trim( $image ) ) )
			{
				continue;
			}

			$Album->addImage( Util::toSting( $image['size'] ), $imageUrl );
		}

		$this->addTracks( $Album, $AlbumXml->tracks );
		$this->addTopTags( $Album, $AlbumXml->toptags );
		$this->addBiography( $Album, $AlbumXml->wiki );

		return $Album;
	}

	/**
	 * @param string $albumName
	 * @return Data\Album\Collection
	 */
	public function search( $albumName )
	{
		$params = array(
			'album' => $albumName,
		);

		$result = $this->getClient()->get( self::PREFIX . 'search', $params );

		/** @var $Xml \SimpleXMLElement */
		$Xml = simplexml_load_string( trim( $result ) );
		$Xml->registerXPathNamespace( 'opensearch', 'http://a9.com/-/spec/opensearch/1.1/' );

		$totalResults = (int) current( $Xml->xpath( '//opensearch:totalResults' ) );
		$itemsPerPage = (int) current( $Xml->xpath( '//opensearch:itemsPerPage' ) );

		$pages = ceil( $totalResults / $itemsPerPage );

		$AlbumCollection = new Data\Album\Collection();
		$iterations      = 30;

		for ( $i = 1; $i <= $pages; $i++ )
		{
			if ( $i > $iterations )
			{
				$iterations += 30;
				sleep( 10 );
			}

			$params['page'] = $i;

			$AlbumCollection->addAlbums( $this->fetchAdditionalPage( self::PREFIX . 'search', $params ) );
		}

		return $AlbumCollection;
	}

	/**
	 * @param string $artistName
	 * @param string $albumName
	 * @param bool $autocorrect
	 * @return Data\Tag\Collection
	 */
	public function getTopTags( $artistName, $albumName, $autocorrect = false )
	{
		$params = array(
			'artist'      => $artistName,
			'album'       => $albumName,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTopTagCollection( self::PREFIX . 'getTopTags', $params );
	}

	/**
	 * @param string $mbId
	 * @return Data\Tag\Collection
	 */
	public function getTopTagsByMbid( $mbId )
	{
		$params = array(
			'mbid' => $mbId,
		);

		return $this->fetchTopTagCollection( self::PREFIX . 'getTopTags', $params );
	}

	/**
	 * @param string $method
	 * @param array $params
	 * @return Data\Tag\Collection
	 */
	private function fetchTopTagCollection( $method, array $params )
	{
		$result = $this->getClient()->get( $method, $params );

		/** @var $Xml \SimpleXMLElement */
		$Xml               = simplexml_load_string( trim( $result ) );
		$TopTagsCollection = new Data\Tag\Collection();

		$TopTagsCollection->setArtistName( Util::toSting( $Xml->toptags['artist'] ) );
		$TopTagsCollection->setAlbumName( Util::toSting( $Xml->toptags['album'] ) );

		foreach ( $Xml->toptags->tag as $tagRow )
		{
			$Tag = new Data\Tag\Tag();

			$Tag->setName( Util::toSting( $tagRow->name ) );
			$Tag->setUrl( Util::toSting( $tagRow->url ) );
			$Tag->setCount( (int) $tagRow->count );

			$TopTagsCollection->addTag( $Tag );
		}

		return $TopTagsCollection;
	}

	/**
	 * @param string $method
	 * @param array $params
	 * @return array
	 */
	private function fetchAdditionalPage( $method, array $params )
	{
		$result = $this->getClient()->get( $method, $params );

		/** @var $Xml \SimpleXMLElement */
		$Xml = simplexml_load_string( trim( $result ) );

		$albums = array();

		foreach ( $Xml->results->albummatches->album as $albumRow )
		{
			$Album = new Data\Album\Album();

			$Album->setId( (int) $albumRow->id );
			$Album->setName( (string) $albumRow->name );
			$Album->setArtist( (string) $albumRow->artist );
			$Album->setUrl( (string) $albumRow->url );
			$Album->setStreamable( (bool) ( (int) $albumRow->streamable ) );
			$Album->setMbid( (string) $albumRow->mbid );

			foreach ( $albumRow->image as $image )
			{
				if ( '' === ( $imageUrl = trim( $image ) ) )
				{
					continue;
				}

				$Album->addImage( (string) $image['size'], $imageUrl );
			}

			$albums[] = $Album;
		}

		return $albums;
	}

	/**
	 * @param Data\Album\Album $Album
	 * @param \SimpleXMLElement $Tracks
	 */
	private function addTracks( Data\Album\Album $Album, \SimpleXMLElement $Tracks )
	{
		$TrackCollection = new Data\Track\Collection();

		/** @var $TrackXml \SimpleXMLElement */
		foreach ( $Tracks->track as $TrackXml )
		{
			$Track = new Data\Track\Track();

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

			$TrackCollection->addTrack( $Track );
		}

		$Album->setTracks( $TrackCollection );
	}

	/**
	 * @param Data\Album\Album $Album
	 * @param \SimpleXMLElement $TopTags
	 */
	private function addTopTags( Data\Album\Album $Album, \SimpleXMLElement $TopTags )
	{
		$TopTagCollection = new Data\Tag\Collection();

		/** @var $TagXml \SimpleXMLElement */
		foreach ( $TopTags->tag as $TagXml )
		{
			$Tag = new Data\Tag\Tag();

			$Tag->setName( Util::toSting( $TagXml->name ) );
			$Tag->setUrl( Util::toSting( $TagXml->url ) );

			$TopTagCollection->addTag( $Tag );
		}

		$Album->setTopTags( $TopTagCollection );
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
