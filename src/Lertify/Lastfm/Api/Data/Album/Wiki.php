<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS,

	DateTime;

class Wiki
{
	/**
	 * @JMS\Accessor(setter="setPublished", getter="getPublished")
	 * @JMS\Type("string")
	 * @var \DateTime
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
	 * @param string $published
	 */
	public function setPublished( $published )
	{
		$this->published = new DateTime( trim( $published ) );
	}

	/**
	 * @return \DateTime
	 */
	public function getPublished()
	{
		return $this->published;
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