<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection,

	JMS\Serializer\Annotation as JMS;

class ShoutsCollection extends ArrayCollection
{
	/**
     * @JMS\Type("array<Lertify\Lastfm\Api\Data\Album\Shout>")
     * @JMS\XmlList(inline=true, entry="shout")
	 * @var \Lertify\Lastfm\Api\Data\Album\Shout[]
     */
    protected $items;

	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $artist;

	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $album;

	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $page;

	/**
	 * @JMS\XmlAttribute
	 * @JMS\SerializedName("perPage")
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $perPage;

	/**
	 * @JMS\XmlAttribute
	 * @JMS\SerializedName("totalPages")
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $totalPages;

	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $total;

	/**
	 * @return string
	 */
	public function getArtist()
	{
		return $this->artist;
	}

	/**
	 * @return string
	 */
	public function getAlbum()
	{
		return $this->album;
	}

	/**
	 * @return int
	 */
	public function getPage()
	{
		return $this->page;
	}

	/**
	 * @return int
	 */
	public function getPerPage()
	{
		return $this->perPage;
	}

	/**
	 * @return int
	 */
	public function getTotalPages()
	{
		return $this->totalPages;
	}

	/**
	 * @return int
	 */
	public function getTotal()
	{
		return $this->total;
	}
}