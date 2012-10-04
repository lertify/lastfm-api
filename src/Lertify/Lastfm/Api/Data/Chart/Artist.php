<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Chart;

class Artist extends \Lertify\Lastfm\Api\Data\Artist
{
	/**
	 * @var int
	 */
	private $percentageChange;

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
}
