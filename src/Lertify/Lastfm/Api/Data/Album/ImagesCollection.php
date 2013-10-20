<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	JMS\Serializer\Annotation as JMS;

class ImagesCollection extends ArrayCollection
{
	/**
     * @JMS\Type("array<Lertify\Lastfm\Api\Data\Album\Image>")
	 * @JMS\XmlList(inline=true, entry="image")
	 * @var \Lertify\Lastfm\Api\Data\Album\Image[]
     */
    protected $items;
}