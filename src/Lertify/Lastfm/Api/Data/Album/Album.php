<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class Album extends \Lertify\Lastfm\Api\Data\Album
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	protected $artist;

	/**
	 * @var bool
	 */
	private $streamable = false;

	/**
	 * @var string
	 */
	private $releaseDate = '';

	/**
	 * @var int
	 */
	private $listeners = 0;

	/**
	 * @var ArrayCollection
	 */
	private $tracks;

	/**
	 * @var ArrayCollection
	 */
	private $topTags;

	/**
	 * @var string
	 */
	private $wikiPublishedAt;

	/**
	 * @var string
	 */
	private $wikiSummary;

	/**
	 * @var string
	 */
	private $wikiContent;

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
	 * @param string $artist
	 */
	public function setArtist( $artist )
	{
		$this->artist = $artist;
	}

	/**
	 * @return string
	 */
	public function getArtist()
	{
		return $this->artist;
	}

	/**
	 * @param bool $streamable
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;
	}

	/**
	 * @return bool
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param string $releaseDate
	 */
	public function setReleaseDate( $releaseDate )
	{
		$this->releaseDate = $releaseDate;
	}

	/**
	 * @return string
	 */
	public function getReleaseDate()
	{
		return $this->releaseDate;
	}

	/**
	 * @param int $listeners
	 */
	public function setListeners( $listeners )
	{
		$this->listeners = $listeners;
	}

	/**
	 * @return int
	 */
	public function getListeners()
	{
		return $this->listeners;
	}

	/**
	 * @param ArrayCollection $Tracks
	 */
	public function setTracks( ArrayCollection $Tracks )
	{
		$this->tracks = $Tracks;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getTracks()
	{
		return $this->tracks;
	}

	/**
	 * @param ArrayCollection $TopTags
	 */
	public function setTopTags( ArrayCollection $TopTags )
	{
		$this->topTags = $TopTags;
	}

	/**
	 * @return ArrayCollection
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
}
