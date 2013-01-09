<?php
namespace Lertify\Lastfm\Api\Data;

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
	 * @var string
	 */
	private $author;

	/**
	 * @var string
	 */
	private $date;

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
	 * @param string $body
	 */
	public function setBody( $body )
	{
		$this->body = $body;
	}

	/**
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @param string $author
	 */
	public function setAuthor( $author )
	{
		$this->author = $author;
	}

	/**
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
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
}
