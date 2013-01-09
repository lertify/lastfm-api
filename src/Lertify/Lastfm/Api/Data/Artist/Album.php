<?php
namespace Lertify\Lastfm\Api\Data\Artist;

class Album extends \Lertify\Lastfm\Api\Data\Album
{
	/**
	 * @var int
	 */
	private $rank;

	/**
	 * @param int $rank
	 */
	public function setRank( $rank )
	{
		$this->rank = $rank;
	}

	/**
	 * @return int
	 */
	public function getRank()
	{
		return $this->rank;
	}
}
