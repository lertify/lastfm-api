<?php
namespace Lertify\Lastfm\Api\Data;

use Lertify\Lastfm\Api\Data\User\User,

	DateTime;

class Shout
{
	/**
	 * @var string
	 */
	private $artist;

	/**
	 * @var string
	 */
	private $body;

	/**
	 * @var \Lertify\Lastfm\Api\Data\User\User
	 */
	private $author;

	/**
	 * @var \DateTime
	 */
	private $date;

	/**
	 * @param string $artist
	 * @return \Lertify\Lastfm\Api\Data\Shout
	 */
	public function setArtist( $artist )
	{
		$this->artist = $artist;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getArtist()
	{
		return $this->artist;
	}

	/**
	 * @param string $body
	 * @return \Lertify\Lastfm\Api\Data\Shout
	 */
	public function setBody( $body )
	{
		$this->body = $body;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\User\User $Author
	 * @return \Lertify\Lastfm\Api\Data\Shout
	 */
	public function setAuthor( User $Author )
	{
		$this->author = $Author;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @param \DateTime $Date
	 * @return \Lertify\Lastfm\Api\Data\Shout
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
}
