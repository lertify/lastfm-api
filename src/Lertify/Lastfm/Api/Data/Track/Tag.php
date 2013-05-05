<?php
namespace Lertify\Lastfm\Api\Data\Track;

use Lertify\Lastfm\Api\Data;

class Tag extends Data\Tag
{
	/**
	 * @var string
	 */
	protected $artist;

	/**
	 * @var string
	 */
	protected $track;

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
	 * @param string $track
	 */
	public function setTrack( $track )
	{
		$this->track = $track;
	}

	/**
	 * @return string
	 */
	public function getTrack()
	{
		return $this->track;
	}
}