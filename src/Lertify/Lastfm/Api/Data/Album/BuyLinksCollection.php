<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

class BuyLinksCollection
{
	/**
     * @JMS\Type("Lertify\Lastfm\Api\Data\Album\AffiliationsCollection")
	 * @var \Lertify\Lastfm\Api\Data\Album\AffiliationsCollection
     */
    protected $affiliations;

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\AffiliationsCollection
	 */
	public function getAffiliations()
	{
		return $this->affiliations;
	}
}