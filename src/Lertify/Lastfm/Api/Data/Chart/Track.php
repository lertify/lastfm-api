<?php
namespace Lertify\Lastfm\Api\Data\Chart;

class Track extends \Lertify\Lastfm\Api\Data\Track
{
	/**
	 * @var int
	 */
	private $percentageChange;

	/**
	 * @var int
	 */
	private $loves;

	/**
	 * @param int $percentageChange
	 */
	public function setPercentageChange( $percentageChange )
	{
		$this->percentageChange = $percentageChange;
	}

	/**
	 * @return int
	 */
	public function getPercentageChange()
	{
		return $this->percentageChange;
	}

	/**
	 * @param int $loves
	 */
	public function setLoves( $loves )
	{
		$this->loves = $loves;
	}

	/**
	 * @return int
	 */
	public function getLoves()
	{
		return $this->loves;
	}
}
