<?php
/**
 * @author   Eugene Serkin <jeserkin@gmail.com>
 * @version  $Id:$
 */
namespace Lertify\Lastfm\Api\Data\Playlist;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class Playlist
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var string
	 */
	private $date;

	/**
	 * @var int
	 */
	private $size;

	/**
	 * @var int
	 */
	private $duration;

	/**
	 * @var bool
	 */
	private $streamable;

	/**
	 * @var string
	 */
	private $creator;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var ArrayCollection
	 */
	private $images;

	/**
	 * @var User
	 */
	private $user;

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
	 * @param string $title
	 */
	public function setTitle( $title )
	{
		$this->title = $title;
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
	 */
	public function setDescription( $description )
	{
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param string $date
	 */
	public function setDate( $date )
	{
		$this->date = $date;
	}

	/**
	 * @return string
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @param int $size
	 */
	public function setSize( $size )
	{
		$this->size = $size;
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
	 */
	public function setDuration( $duration )
	{
		$this->duration = $duration;
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
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;
	}

	/**
	 * @return boolean
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param string $creator
	 */
	public function setCreator( $creator )
	{
		$this->creator = $creator;
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
	 * @param ArrayCollection $Images
	 */
	public function setImages( $Images )
	{
		$this->images = $Images;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param User $User
	 */
	public function setUser( User $User )
	{
		$this->user = $User;
	}

	/**
	 * @return User
	 */
	public function getUser()
	{
		return $this->user;
	}
}
