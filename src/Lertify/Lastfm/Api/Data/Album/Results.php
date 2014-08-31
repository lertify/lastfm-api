<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\XmlNamespace(uri="http://a9.com/-/spec/opensearch/1.1/", prefix="opensearch")
 */
class Results
{
	/**
	 * @JMS\XmlElement(cdata=false, namespace="http://a9.com/-/spec/opensearch/1.1/")
	 * @JMS\SerializedName("totalResults")
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $totalResults;

	/**
	 * @JMS\XmlElement(namespace="http://a9.com/-/spec/opensearch/1.1/")
	 * @JMS\SerializedName("startIndex")
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $startIndex;

	/**
	 * @JMS\XmlElement(namespace="http://a9.com/-/spec/opensearch/1.1/")
	 * @JMS\SerializedName("itemsPerPage")
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $itemsPerPage;

	/**
	 * @JMS\XmlElement(namespace="http://a9.com/-/spec/opensearch/1.1/")
	 * @JMS\SerializedName("Query")
	 * @JMS\Type("Lertify\Lastfm\Api\Data\Album\ResultsQuery")
	 * @var \Lertify\Lastfm\Api\Data\Album\ResultsQuery
	 */
	protected $query;

	/**
	 * @return int
	 */
	public function getTotalResults()
	{
		return $this->totalResults;
	}

	/**
	 * @return int
	 */
	public function getStartIndex()
	{
		return $this->startIndex;
	}

	/**
	 * @return int
	 */
	public function getItemsPerPage()
	{
		return $this->itemsPerPage;
	}

	/**
	 * @return float
	 */
	public function getTotalPages()
	{
		$pages = 1;

		if ( $this->itemsPerPage > 0 )
		{
			$pages = ceil( $this->totalResults / $this->itemsPerPage );
		}

		return $pages;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\ResultsQuery
	 */
	public function getQuery()
	{
		return $this->query;
	}
}