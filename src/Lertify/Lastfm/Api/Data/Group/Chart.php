<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id:$
 */
namespace Lertify\Lastfm\Api\Data\Group;

class Chart
{
	/**
	 * @var int
	 */
	private $from;

	/**
	 * @var int
	 */
	private $to;

	/**
	 * @param int $from
	 */
	public function setFrom( $from )
	{
		$this->from = $from;
	}

	/**
	 * @return int
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * @param int $to
	 */
	public function setTo( $to )
	{
		$this->to = $to;
	}

	/**
	 * @return int
	 */
	public function getTo()
	{
		return $this->to;
	}
}
