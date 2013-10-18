<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\XmlRoot("track")
 */
class Tracks
{
	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $rank;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $name;

	/**
	 * In seconds
	 *
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $duration;

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
	 * @JMS\Type("Lertify\Lastfm\Api\Data\Album\Streamable")
	 * @var \Lertify\Lastfm\Api\Data\Album\Streamable
	 */
	protected $streamable;

	/**
	 * @JMS\Type("Lertify\Lastfm\Api\Data\Album\Artist")
	 * @var \Lertify\Lastfm\Api\Data\Album\Artist
	 */
	protected $artist;

	/**
	 * @return int
	 */
	public function getRank()
	{
		return $this->rank;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return int
	 */
	public function getDuration()
	{
		return $this->duration;
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

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\Streamable
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\Artist
	 */
	public function getArtist()
	{
		return $this->artist;
	}
}