<?php
namespace Lertify\Lastfm\Api\Data\Playlist;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	DateTime;

class Playlist
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var int
	 */
	protected $size;

	/**
	 * @var int
	 */
	protected $duration;

	/**
	 * @var bool
	 */
	protected $streamable;

	/**
	 * @var string
	 */
	protected $creator;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $images;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Playlist\User
	 */
	protected $user;

	/**
	 * @param int $id
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
	 */
	public function setId( $id )
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param string $title
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
	 */
	public function setTitle( $title )
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $description
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
	 */
	public function setDescription( $description )
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param int $size
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
	 */
	public function setSize( $size )
	{
		$this->size = $size;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * @param int $duration
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
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
	 * @param bool $streamable
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param string $creator
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
	 */
	public function setCreator( $creator )
	{
		$this->creator = $creator;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCreator()
	{
		return $this->creator;
	}

	/**
	 * @param string $url
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
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
	 * @param \DateTime $Date
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
	 */
	public function setDate( DateTime $Date )
	{
		$this->date = $Date;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Images
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
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
	 * @param \Lertify\Lastfm\Api\Data\Playlist\User $User
	 * @return \Lertify\Lastfm\Api\Data\Playlist\Playlist
	 */
	public function setUser( User $User )
	{
		$this->user = $User;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Playlist\User
	 */
	public function getUser()
	{
		return $this->user;
	}
}
