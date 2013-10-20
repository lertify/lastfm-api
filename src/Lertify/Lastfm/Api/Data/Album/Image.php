<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

class Image
{
	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $size;

	/**
	 * @JMS\XmlValue
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $image;

	/**
	 * @return string
	 */
	public function getSize()
	{
		return $this->size;
	}

	/**
	 * @return string
	 */
	public function getImage()
	{
		return $this->image;
	}
}