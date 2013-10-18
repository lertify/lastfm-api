<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	JMS\Serializer\Annotation as JMS;

class TracksCollection extends ArrayCollection
{
	/**
     * @JMS\Type("array<Lertify\Lastfm\Api\Data\Album\Tracks>")
     * @JMS\XmlList(inline=true, entry="track")
	 * @var \Lertify\Lastfm\Api\Data\Album\Tracks[]
     */
    protected $items;
}