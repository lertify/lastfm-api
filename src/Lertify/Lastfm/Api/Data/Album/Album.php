<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Album;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class Album
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $artist;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var bool
	 */
	private $streamable = false;

	/**
	 * @var string
	 */
	private $mbid;

	/**
	 * @var ArrayCollection
	 */
	private $images = array();

	/**
	 * @var string
	 */
	private $releaseDate = '';

	/**
	 * @var int
	 */
	private $listeners = 0;

	/**
	 * @var int
	 */
	private $playcount = 0;

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
	 * @param string $name
	 */
	public function setName( $name )
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
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
	 * @param string $url
	 */
	public function setUrl( $url )
	{
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
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
	 * @param string $mbid
	 */
	public function setMbid( $mbid )
	{
		$this->mbid = $mbid;
	}

	/**
	 * @return string
	 */
	public function getMbid()
	{
		return $this->mbid;
	}

	/**
	 * @param ArrayCollection $Images
	 */
	public function setImages( ArrayCollection $Images )
	{
		$this->images = $Images;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
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
	 * @param int $playcount
	 */
	public function setPlaycount( $playcount )
	{
		$this->playcount = $playcount;
	}

	/**
	 * @return int
	 */
	public function getPlaycount()
	{
		return $this->playcount;
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
