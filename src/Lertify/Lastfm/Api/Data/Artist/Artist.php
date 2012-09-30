<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Artist;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class Artist
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $mbid;

    /**
     * @var string
     */
    private $url;

	/**
	 * @var ArrayCollection
	 */
	private $images;

	/**
	 * @var bool
	 */
	private $streamable;

	/**
	 * @var int
	 */
	private $listeners;

	/**
	 * @var int
	 */
	private $playcount;

	/**
	 * @var int
	 */
	private $userplaycount;

	/**
	 * @var ArrayCollection
	 */
	private $similar;

	/**
	 * @var float
	 */
	private $match;

	/**
	 * @var ArrayCollection
	 */
	private $tags;

	/**
	 * @var string
	 */
	private $published;

	/**
	 * @var string
	 */
	private $summary;

	/**
	 * @var string
	 */
	private $content;

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
	 * @param ArrayCollection $Images
	 */
	public function setImages( $Images )
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
	 * @param int $userplaycount
	 */
	public function setUserplaycount( $userplaycount )
	{
		$this->userplaycount = $userplaycount;
	}

	/**
	 * @return int
	 */
	public function getUserplaycount()
	{
		return $this->userplaycount;
	}

	/**
	 * @param ArrayCollection $similar
	 */
	public function setSimilar( $similar )
	{
		$this->similar = $similar;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getSimilar()
	{
		return $this->similar;
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

	/**
	 * @param ArrayCollection $Tags
	 */
	public function setTags( $Tags )
	{
		$this->tags = $Tags;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getTags()
	{
		return $this->tags;
	}

	/**
	 * @param string $published
	 */
	public function setPublished( $published )
	{
		$this->published = $published;
	}

	/**
	 * @return string
	 */
	public function getPublished()
	{
		return $this->published;
	}

	/**
	 * @param string $summary
	 */
	public function setSummary( $summary )
	{
		$this->summary = $summary;
	}

	/**
	 * @return string
	 */
	public function getSummary()
	{
		return $this->summary;
	}

	/**
	 * @param string $content
	 */
	public function setContent( $content )
	{
		$this->content = $content;
	}

	/**
	 * @return string
	 */
	public function getContent()
	{
		return $this->content;
	}
}
