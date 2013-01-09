<?php
namespace Lertify\Lastfm\Api\Data\Geo;

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
