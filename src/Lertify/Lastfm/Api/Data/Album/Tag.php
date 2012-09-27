<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Album;

class Tag extends \Lertify\Lastfm\Api\Data\Tag
{
	/**
	 * @var string
	 */
	private $artist;

	/**
	 * @var string
	 */
	private $album;

	/**
	 * @var int
	 */
	private $count;

	/**
	 * @param string $artist
	 */
	public function setArtist( $artist )
	{
		$this->artist = $artist;
	}

	/**
	 * @return string
	 */
	public function getArtist()
	{
		return $this->artist;
	}

	/**
	 * @param string $album
	 */
	public function setAlbum( $album )
	{
		$this->album = $album;
	}

	/**
	 * @return string
	 */
	public function getAlbum()
	{
		return $this->album;
	}

	/**
	 * @param int $count
	 */
	public function setCount( $count )
	{
		$this->count = $count;
	}

	/**
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}
}
