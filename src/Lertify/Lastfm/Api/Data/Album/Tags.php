<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\XmlRoot("tag")
 */
class Tags
{
	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $name;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $url;

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}
}