<?php
namespace Lertify\Lastfm\Api\Data\Artist;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	JMS\Serializer\Annotation as JMS;

class CorrectionsCollection extends ArrayCollection
{
	/**
     * @JMS\Type("array<Lertify\Lastfm\Api\Data\Artist\Correction>")
     * @JMS\XmlList(inline=true, entry="correction")
     * @var \Lertify\Lastfm\Api\Data\Artist\Correction[]
     */
    protected $items;
}