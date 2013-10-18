<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

class Artist
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
	protected $mbid;

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
	public function getMbid()
	{
		return $this->mbid;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}
}