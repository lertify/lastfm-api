<?php
namespace Lertify\Lastfm\Api\Data;

class Track
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
	protected $mbId;

	/**
	 * @var int (seconds)
	 */
	protected $duration;

	/**
	 * @var bool
	 */
	protected $streamable = false;

	/**
	 * @var bool
	 */
	protected $streamableFulltrack = false;

	/**
	 * @var int
	 */
	protected $rank;

	/**
	 * @var int
	 */
	protected $playcount;

	/**
	 * @var int
	 */
	protected $listeners;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Artist
	 */
	protected $arist;

	/**
	 * @var string
	 */
	protected $artistName;

	/**
	 * @var string
	 */
	protected $artistMbId;

	/**
	 * @var string
	 */
	protected $artistUrl;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Track\Album
	 */
	protected $album;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $images;

	/**
	 * @param string $name
	 * @return \Lertify\Lastfm\Api\Data\Track
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
	 * @return \Lertify\Lastfm\Api\Data\Track
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
	 * @param string $mbId
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setMbId( $mbId )
	{
		$this->mbId = $mbId;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMbId()
	{
		return $this->mbId;
	}

	/**
	 * @param int $duration
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setDuration( $duration )
	{
		$this->duration = $duration;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	/**
	 * @param boolean $streamable
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param boolean $streamableFulltrack
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setStreamableFulltrack( $streamableFulltrack )
	{
		$this->streamableFulltrack = $streamableFulltrack;

		return $this;
	}

	/**
	 * @return boolean
	 */
	public function getStreamableFulltrack()
	{
		return $this->streamableFulltrack;
	}

	/**
	 * @param int $rank
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setRank( $rank )
	{
		$this->rank = $rank;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getRank()
	{
		return $this->rank;
	}

	/**
	 * @param int $playcount
	 * @return \Lertify\Lastfm\Api\Data\Track
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
	 * @param int $listeners
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setListeners( $listeners )
	{
		$this->listeners = $listeners;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getListeners()
	{
		return $this->listeners;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Artist $Artist
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setArtist( Artist $Artist )
	{
		$this->arist = $Artist;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Artist
	 */
	public function getArtist()
	{
		return $this->arist;
	}

	/**
	 * @param string $artistName
	 */
	public function setArtistName( $artistName )
	{
		$this->artistName = $artistName;
	}

	/**
	 * @return string
	 */
	public function getArtistName()
	{
		return $this->artistName;
	}

	/**
	 * @param string $artistMbId
	 */
	public function setArtistMbId( $artistMbId )
	{
		$this->artistMbId = $artistMbId;
	}

	/**
	 * @return string
	 */
	public function getArtistMbId()
	{
		return $this->artistMbId;
	}

	/**
	 * @param string $artistUrl
	 */
	public function setArtistUrl( $artistUrl )
	{
		$this->artistUrl = $artistUrl;
	}

	/**
	 * @return string
	 */
	public function getArtistUrl()
	{
		return $this->artistUrl;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album $Album
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setAlbum( Album $Album )
	{
		$this->album = $Album;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Track\Album
	 */
	public function getAlbum()
	{
		return $this->album;
	}

	/**
	 * @param ArrayCollection $Images
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function setImages( ArrayCollection $Images )
	{
		$this->images = $Images;

		return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}
}
