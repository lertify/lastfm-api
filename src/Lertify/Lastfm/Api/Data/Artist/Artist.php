<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Artist;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class Artist extends \Lertify\Lastfm\Api\Data\Artist
{
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
