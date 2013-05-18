<?php
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\Artist,

	Lertify\Lastfm\Api\Data\ArrayCollection,

	DateTime;

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
	private $streamable;

	/**
	 * @var int
	 */
	private $listeners;

	/**
	 * @var string
	 */
	private $wikiSummary;

	/**
	 * @var string
	 */
	private $wikiContent;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private $tracks;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private $topTags;

	/**
	 * @var \DateTime
	 */
	private $wikiPublishedAt;

	/**
	 * @param int $id
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setId( $id )
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Artist $Artist
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setArtist( Artist $Artist )
	{
		$this->artist = $Artist;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param int $listeners
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setListeners( $listeners )
	{
		$this->listeners = $listeners;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getListeners()
	{
		return $this->listeners;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Tracks
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setTracks( ArrayCollection $Tracks )
	{
		$this->tracks = $Tracks;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTracks()
	{
		return $this->tracks;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $TopTags
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setTopTags( ArrayCollection $TopTags )
	{
		$this->topTags = $TopTags;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTopTags()
	{
		return $this->topTags;
	}

	/**
	 * @param \DateTime $WikiPublishedAt
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setWikiPublishedAt( DateTime $WikiPublishedAt )
	{
		$this->wikiPublishedAt = $WikiPublishedAt;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setWikiSummary( $wikiSummary )
	{
		$this->wikiSummary = $wikiSummary;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Album
	 */
	public function setWikiContent( $wikiContent )
	{
		$this->wikiContent = $wikiContent;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getWikiContent()
	{
		return $this->wikiContent;
	}
}
