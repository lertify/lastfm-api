<?php
namespace Lertify\Lastfm\Api\Data\Track;

use Lertify\Lastfm\Api\Data;

class Shout extends Data\Shout
{
	/**
	 * @var string
	 */
	protected $track;

	/**
	 * @param $track
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