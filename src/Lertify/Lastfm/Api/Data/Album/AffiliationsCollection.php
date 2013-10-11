<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

class AffiliationsCollection
{
	/**
     * @JMS\Type("Lertify\Lastfm\Api\Data\Album\PhysicalsCollection")
	 * @var \Lertify\Lastfm\Api\Data\Album\PhysicalsCollection
     */
	protected $physicals;

	/**
     * @JMS\Type("Lertify\Lastfm\Api\Data\Album\DownloadsCollection")
	 * @var \Lertify\Lastfm\Api\Data\Album\DownloadsCollection
     */
	protected $downloads;

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\PhysicalsCollection
	 */
	public function getPhysicals()
	{
		return $this->physicals;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\DownloadsCollection
	 */
	public function getDownloads()
	{
		return $this->downloads;
	}
}