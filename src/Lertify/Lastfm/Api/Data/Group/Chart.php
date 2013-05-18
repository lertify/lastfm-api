<?php
namespace Lertify\Lastfm\Api\Data\Group;

use DateTime;

class Chart
{
	/**
	 * @var \DateTime
	 */
	private $from;

	/**
	 * @var \DateTime
	 */
	private $to;

	/**
	 * @param \DateTime $From
	 * @return \Lertify\Lastfm\Api\Data\Group\Chart
	 */
	public function setFrom( DateTime $From )
	{
		$this->from = $From;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getFrom()
	{
		return $this->from;
	}

	/**
	 * @param \DateTime $To
	 * @return \Lertify\Lastfm\Api\Data\Group\Chart
	 */
	public function setTo( DateTime $To )
	{
		$this->to = $To;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getTo()
	{
		return $this->to;
	}
}
