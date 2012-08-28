<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Album;

class Tag
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
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var int
	 */
	private $count;

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->name;
	}

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
	 * @param string $name
	 */
	public function setName( $name )
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $url
	 */
	public function setUrl( $url )
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
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
