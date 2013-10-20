<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	JMS\Serializer\Annotation as JMS;

class TagsCollection extends ArrayCollection
{
	/**
     * @JMS\Type("array<Lertify\Lastfm\Api\Data\Album\Tag>")
     * @JMS\XmlList(inline=true, entry="tag")
	 * @var \Lertify\Lastfm\Api\Data\Album\Tag[]
     */
    protected $items;
}