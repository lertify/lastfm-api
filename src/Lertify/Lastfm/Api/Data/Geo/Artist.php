<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Geo;

class Artist extends \Lertify\Lastfm\Api\Data\Artist
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
