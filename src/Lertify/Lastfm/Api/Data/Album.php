<?php
namespace Lertify\Lastfm\Api\Data;

use DateTime;

class Album
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $mbid;

	/**
	 * @var int
	 */
	protected $playcount;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Artist
	 */
	protected $artist;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $images;

	/**
	 * @var \DateTime
	 */
	protected $releaseDate;

	/**
	 * @param string $name
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setName( $name )
	{
		$this->name = $name;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setUrl( $url )
	{
		$this->url = $url;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $mbid
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setMbid( $mbid )
	{
		$this->mbid = $mbid;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMbid()
	{
		return $this->mbid;
	}

	/**
	 * @param int $playcount
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setPlaycount( $playcount )
	{
		$this->playcount = $playcount;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPlaycount()
	{
		return $this->playcount;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Images
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setImages( ArrayCollection $Images )
	{
		$this->images = $Images;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Artist $Artist
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setArtist( Artist $Artist )
	{
		$this->artist = $Artist;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Artist
	 */
	public function getArtist()
	{
		return $this->artist;
	}

	/**
	 * @param \DateTime $ReleaseDate
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setReleaseDate( DateTime $ReleaseDate )
	{
		$this->releaseDate = $ReleaseDate;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getReleaseDate()
	{
		return $this->releaseDate;
	}
}
