<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

class Streamable
{
	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $fulltrack;

	/**
	 * @JMS\XmlValue
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $streamable;

	/**
	 * @return int
	 */
	public function getFulltrack()
	{
		return $this->fulltrack;
	}

	/**
	 * @return int
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}
}