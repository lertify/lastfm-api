<?php
namespace Lertify\Lastfm\Api\Data;

use Lertify\Lastfm\Api\Data\Artist\Artist;

class Album
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Artist\Artist
	 */
	protected $artist;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $mbid;

	/**
	 * @var int
	 */
	private $playcount = 0;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private $images;

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $images
	 */
	public function setImages( $images )
	{
		$this->images = $images;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param int $playcount
	 */
	public function setPlaycount( $playcount )
	{
		$this->playcount = $playcount;
	}

	/**
	 * @return int
	 */
	public function getPlaycount()
	{
		return $this->playcount;
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
	 * @param \Lertify\Lastfm\Api\Data\Artist\Artist $Artist
	 */
	public function setArtist( Artist $Artist )
	{
		$this->artist = $Artist;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Artist\Artist
	 */
	public function getArtist()
	{
		return $this->artist;
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
}
