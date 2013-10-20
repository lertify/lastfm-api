<?php
namespace Lertify\Lastfm\Api\Data;

use JMS\Serializer\Annotation as JMS;

class PostResponse
{
	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $status;

	/**
	 * @return string
	 */
	public function getStatus()
	{
		return $this->status;
	}
}