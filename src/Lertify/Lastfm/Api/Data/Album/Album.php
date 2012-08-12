<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Album;

class Album
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $artist;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var bool
	 */
	private $streamable;

	/**
	 * @var string
	 */
	private $mbid;

	/**
	 * @var array
	 */
	private $images = array();

	/**
	 * @param int $id
	 */
	public function setId( $id )
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
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
	 * @param bool $streamable
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;
	}

	/**
	 * @return bool
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param string $mbid
	 */
	public function setMbid( $mbid )
	{
		$this->mbid = $mbid;
	}

	/**
	 * @return string
	 */
	public function getMbid()
	{
		return $this->mbid;
	}

	/**
	 * @param string $size
	 * @param string $url
	 */
	public function addImage( $size, $url )
	{
		$this->images[ $size ] = $url;
	}

	/**
	 * @return array
	 */
	public function getImages()
	{
		return $this->images;
	}
}
