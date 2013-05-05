<?php
namespace Lertify\Lastfm\Api\Data\Track;

use Lertify\Lastfm\Api\Data;

class Album extends Data\Album
{
	/**
	 * @var int
	 */
	protected $position;

	/**
	 * @var string
	 */
	protected $artist;

	/**
	 * @param int $position
	 */
	public function setPosition( $position )
	{
		$this->position = $position;
	}

	/**
	 * @return int
	 */
	public function getPosition()
	{
		return $this->position;
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
}