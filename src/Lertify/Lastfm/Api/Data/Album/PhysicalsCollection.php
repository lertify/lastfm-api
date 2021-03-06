<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	JMS\Serializer\Annotation as JMS;

class PhysicalsCollection extends ArrayCollection
{
	/**
     * @JMS\Type("array<Lertify\Lastfm\Api\Data\Album\Affiliation>")
     * @JMS\XmlList(inline=true, entry="affiliation")
	 * @var \Lertify\Lastfm\Api\Data\Album\Affiliation[]
     */
    protected $items;
}