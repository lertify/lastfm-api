<?php
namespace Lertify\Lastfm\Api\Data\Artist;

use JMS\Serializer\Annotation as JMS;

class Artist
{
	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	private $name;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	private $mbid;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	private $url;

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