<?php
namespace Lertify\Lastfm\Api\Data\Track;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class Track extends \Lertify\Lastfm\Api\Data\Track
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Track\Album
	 */
	protected $album;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $topTags;

	/**
	 * @var string
	 */
	protected $wikiPublishedAt;

	/**
	 * @var string
	 */
	protected $wikiSummary;

	/**
	 * @var string
	 */
	protected $wikiContent;

	/**
	 * @var float
	 */
	protected $match;

	/**
	 * @param int $id
	 */
	public function setId( $id )
	{
		$this->id = $id;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Track\Album $Album
	 */
	public function setAlbum( Album $Album )
	{
		$this->album = $Album;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Track\Album
	 */
	public function getAlbum()
	{
		return $this->album;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $TopTags
	 */
	public function setTopTags( ArrayCollection $TopTags )
	{
		$this->topTags = $TopTags;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTopTags()
	{
		return $this->topTags;
	}

	/**
	 * @param string $wikiPublishedAt
	 */
	public function setWikiPublishedAt( $wikiPublishedAt )
	{
		$this->wikiPublishedAt = $wikiPublishedAt;
	}

	/**
	 * @return string
	 */
	public function getWikiPublishedAt()
	{
		return $this->wikiPublishedAt;
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

	/**
	 * @param float $match
	 */
	public function setMatch( $match )
	{
		$this->match = $match;
	}

	/**
	 * @return float
	 */
	public function getMatch()
	{
		return $this->match;
	}
}