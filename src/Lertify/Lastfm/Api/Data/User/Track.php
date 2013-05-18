<?php
namespace Lertify\Lastfm\Api\Data\User;

use Lertify\Lastfm\Api\Data,

	DateTime;

class Track extends Data\Track
{
	/**
	 * @var \DateTime
	 */
	protected $playedAt;

	/**
	 * @var \DateTime
	 */
	protected $bannedAt;

	/**
	 * @var \DateTime
	 */
	protected $lovedAt;

	/**
	 * @param \DateTime $PlayedAt
	 * @return \Lertify\Lastfm\Api\Data\User\Track
	 */
	public function setPlayedAt( DateTime $PlayedAt )
	{
		$this->playedAt = $PlayedAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getPlayedAt()
	{
		return $this->playedAt;
	}

	/**
	 * @param \DateTime $BannedAt
	 * @return \Lertify\Lastfm\Api\Data\User\Track
	 */
	public function setBannedAt( DateTime $BannedAt )
	{
		$this->bannedAt = $BannedAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getBannedAt()
	{
		return $this->bannedAt;
	}

	/**
	 * @param \DateTime $LovedAt
	 * @return \Lertify\Lastfm\Api\Data\User\Track
	 */
	public function setLovedAt( DateTime $LovedAt )
	{
		$this->lovedAt = $LovedAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getLovedAt()
	{
		return $this->lovedAt;
	}
}