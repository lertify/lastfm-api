<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	JMS\Serializer\Annotation as JMS;

/**
 * @JMS\XmlRoot("albummatches")
 */
class AlbumsCollection extends ArrayCollection
{
	/**
     * @JMS\Type("array<Lertify\Lastfm\Api\Data\Album\Album>")
     * @JMS\XmlList(inline=true, entry="album")
	 * @var \Lertify\Lastfm\Api\Data\Album\Album[]
     */
    protected $items;
}