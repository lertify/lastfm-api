<?php
namespace Lertify\Lastfm\Api\Data\Artist;

use JMS\Serializer\Annotation as JMS;

class Correction
{
	/**
	 * @JMS\Type("integer")
	 * @JMS\XmlAttribute
	 * @var int
	 */
	private $index;

	/**
	 * @JMS\Type("Lertify\Lastfm\Api\Data\Artist\Artist")
	 * @var \Lertify\Lastfm\Api\Data\Artist\Artist
	 */
	private $artist;

	/**
	 * @return int
	 */
	public function getIndex()
	{
		return $this->index;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Artist\Artist
	 */
	public function getArtist()
	{
		return $this->artist;
	}
}