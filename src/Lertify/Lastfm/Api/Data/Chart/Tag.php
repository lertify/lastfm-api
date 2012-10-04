<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Chart;

class Tag extends \Lertify\Lastfm\Api\Data\Tag
{
	/**
	 * @var int
	 */
	private $reach;

	/**
	 * @var int
	 */
	private $taggings;

	/**
	 * @var bool
	 */
	private $streamable;

	/**
	 * @var string
	 */
	private $wikiPublished;

	/**
	 * @var string
	 */
	private $wikiSummary;

	/**
	 * @var string
	 */
	private $wikiContent;

	/**
	 * @param int $reach
	 */
	public function setReach( $reach )
	{
		$this->reach = $reach;
	}

	/**
	 * @return int
	 */
	public function getReach()
	{
		return $this->reach;
	}

	/**
	 * @param int $taggings
	 */
	public function setTaggings( $taggings )
	{
		$this->taggings = $taggings;
	}

	/**
	 * @return int
	 */
	public function getTaggings()
	{
		return $this->taggings;
	}

	/**
	 * @param boolean $streamable
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;
	}

	/**
	 * @return boolean
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param string $wikiPublished
	 */
	public function setWikiPublished( $wikiPublished )
	{
		$this->wikiPublished = $wikiPublished;
	}

	/**
	 * @return string
	 */
	public function getWikiPublished()
	{
		return $this->wikiPublished;
	}

	/**
	 * @param string $wikiSummary
	 */
	public function setWikiSummary( $wikiSummary )
	{
		$this->wikiSummary = $wikiSummary;
	}

	/**
	 * @return string
	 */
	public function getWikiSummary()
	{
		return $this->wikiSummary;
	}

	/**
	 * @param string $wikiContent
	 */
	public function setWikiContent( $wikiContent )
	{
		$this->wikiContent = $wikiContent;
	}

	/**
	 * @return string
	 */
	public function getWikiContent()
	{
		return $this->wikiContent;
	}
}
