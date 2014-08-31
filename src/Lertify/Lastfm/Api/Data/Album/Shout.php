<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS,

	DateTime;

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
	 * @JMS\Accessor(setter="setDate", getter="getDate")
	 * @JMS\Type("string")
	 * @var \DateTime
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
	 * @param string $date
	 */
	public function setDate( $date )
	{
		$this->date = new DateTime( trim( $date ) );
	}

	/**
	 * @return \DateTime
	 */
	public function getDate()
	{
		return $this->date;
	}
}