<?php
namespace Lertify\Lastfm\Api\Data\Tag;

class Artist extends \Lertify\Lastfm\Api\Data\Artist
{
	/**
	 * @var int
	 */
	private $weight;

	/**
	 * @param int $weight
	 */
	public function setWeight( $weight )
	{
		$this->weight = $weight;
	}

	/**
	 * @return int
	 */
	public function getWeight()
	{
		return $this->weight;
	}
}
