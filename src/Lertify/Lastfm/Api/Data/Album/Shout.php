<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS,

	DateTime;

/**
 * @JMS\XmlRoot("shout")
 */
class Shout
{
	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $body;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $author;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $date;

	/**
	 * @return string
	 */
	public function getBody()
	{
		return $this->body;
	}

	/**
	 * @return string
	 */
	public function getAuthor()
	{
		return $this->author;
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return new DateTime( trim( $this->date ) );
	}
}
