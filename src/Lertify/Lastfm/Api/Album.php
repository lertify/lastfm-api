<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Api\Data,
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

		return $this->get( 'Album\TopTagsCollection', self::PREFIX . 'getTopTags', $params );
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

			/** @var \Lertify\Lastfm\Api\Data\Album\AlbumResults $List */
			$List = $self->get( 'Album\AlbumResults', \Lertify\Lastfm\Api\Album::PREFIX . 'search', $params );

			return array(
				'results'       => $List->getAlbummatches(),
				'total_pages'   => $List->getTotalPages(),
				'total_results' => $List->getTotalResults(),
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
	 * @return \Lertify\Lastfm\Api\Data\PostResponse
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

		return $this->post( 'PostResponse', self::PREFIX . 'share', $params, array( 'is_signed' => true ) );
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
			/** @var \Lertify\Lastfm\Api\Data\Album\ShoutsCollection $List */
			$List   = $self->get( 'Album\ShoutsCollection', \Lertify\Lastfm\Api\Album::PREFIX . 'getShouts', $params );

			return array(
				'results'       => $List,
				'total_pages'   => $List->getTotalPages(),
				'total_results' => $List->getTotal(),
			);
		};

		return new PagedCollection( $resultCallback );
	}
}