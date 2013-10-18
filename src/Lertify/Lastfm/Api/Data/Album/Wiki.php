<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS,

	DateTime;

class Wiki
{
	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $published;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $summary;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $content;

	/**
	 * @return \DateTime
	 */
	public function getPublished()
	{
		return new DateTime( trim( $this->published ) );
	}

	/**
	 * @return string
	 */
	public function getSummary()
	{
		return $this->summary;
	}

	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}
}