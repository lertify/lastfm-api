<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Track;

class Collection
{
	/**
	 * @var array
	 */
	private $tracks = array();

	/**
	 * @param Track $Track
	 */
	public function addTrack( Track $Track )
	{
		$this->tracks[] = $Track;
	}

	/**
	 * @return array
	 */
	public function getTracks()
	{
		return $this->tracks;
	}

	/**
	 * @return int
	 */
	public function count()
	{
		return count( $this->tracks );
	}
}
