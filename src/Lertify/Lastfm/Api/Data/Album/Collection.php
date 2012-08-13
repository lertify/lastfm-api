<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Album;

class Collection
{
	/**
	 * @var array
	 */
	private $albums = array();

	/**
	 * @param Album $album
	 */
	public function addAlbum( Album $album )
	{
		$this->albums[] = $album;
	}

	/**
	 * @param array $albumsList
	 */
	public function addAlbums( array $albumsList )
	{
		$this->albums = array_merge( $this->albums, $albumsList );
	}

	/**
	 * @return array
	 */
	public function getAlbums()
	{
		return $this->albums;
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count( $this->albums );
	}
}
