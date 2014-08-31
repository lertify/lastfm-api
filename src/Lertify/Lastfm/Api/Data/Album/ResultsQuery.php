<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

class ResultsQuery
{
	/**
	 * @JMS\XmlAttribute
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $role;

	/**
	 * @JMS\XmlAttribute
	 * @JMS\SerializedName("searchTerms")
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $searchTerms;

	/**
	 * @JMS\XmlAttribute
	 * @JMS\SerializedName("startPage")
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $startPage;

	/**
	 * @return string
	 */
	public function getRole()
	{
		return $this->role;
	}

	/**
	 * @return string
	 */
	public function getSearchTerms()
	{
		return $this->searchTerms;
	}

	/**
	 * @return int
	 */
	public function getStartPage()
	{
		return $this->startPage;
	}
}