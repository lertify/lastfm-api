<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data;

class Album extends AbstractApi
{
	const
		PREFIX = 'album.';

	/**
	 * @param $albumName
	 * @return Data\Album\Collection
	 */
	public function search( $albumName )
	{
		$params = array(
			'method'  => self::PREFIX . __FUNCTION__,
			'album'   => $albumName,
		);

		$result = $this->getClient()->get( '', $params );

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

			$AlbumCollection->addAlbums( $this->fetchAdditionalPage( $params ) );
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
			'method'      => self::PREFIX . __FUNCTION__,
			'artist'      => $artistName,
			'album'       => $albumName,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTopTagCollection( $params );
	}

	/**
	 * @param string $mbid
	 * @param bool $autocorrect
	 * @return Data\Tag\Collection
	 */
	public function getTopTagsByMbid( $mbid, $autocorrect = false )
	{
		$params = array(
			'method'      => self::PREFIX . __FUNCTION__,
			'mbid'        => $mbid,
			'autocorrect' => $autocorrect,
		);

		return $this->fetchTopTagCollection( $params );
	}

	/**
	 * @param array $params
	 * @return Data\Tag\Collection
	 */
	private function fetchTopTagCollection( array $params )
	{
		$result = $this->getClient()->get( '', $params );

		/** @var $Xml \SimpleXMLElement */
		$Xml               = simplexml_load_string( trim( $result ) );
		$TopTagsCollection = new Data\Tag\Collection();

		$TopTagsCollection->setArtistName( trim( $Xml->toptags['artist'] ) );
		$TopTagsCollection->setAlbumName( trim( $Xml->toptags['album'] ) );

		foreach ( $Xml->toptags->tag as $tagRow )
		{
			$Tag = new Data\Tag\Tag();

			$Tag->setName( trim( $tagRow->name ) );
			$Tag->setUrl( trim( $tagRow->url ) );
			$Tag->setCount( (int) $tagRow->count );

			$TopTagsCollection->addTag( $Tag );
		}

		return $TopTagsCollection;
	}

	/**
	 * @param array $params
	 * @return array
	 */
	private function fetchAdditionalPage( array $params )
	{
		$result = $this->getClient()->get( '', $params );

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
}
