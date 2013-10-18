<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	JMS\Serializer\Annotation as JMS;

class ToptagsCollection extends ArrayCollection
{
	/**
     * @JMS\Type("array<Lertify\Lastfm\Api\Data\Album\Tags>")
     * @JMS\XmlList(inline=true, entry="tag")
	 * @var \Lertify\Lastfm\Api\Data\Album\Tags[]
     */
    protected $items;
}