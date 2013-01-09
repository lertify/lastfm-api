<?php
namespace Lertify\Lastfm\Api\Data;

class Event
{
	/**
	 * @var int
	 */
	private $id;

	/**
	 * @var string
	 */
	private $title;

	/**
	 * @var ArrayCollection
	 */
	private $artists;

	/**
	 * @var string
	 */
	private $headliner;

	/**
	 * @var Venue
	 */
	private $venue;

	/**
	 * @var string
	 */
	private $startDate;

	/**
	 * @var string
	 */
	private $description;

	/**
	 * @var ArrayCollection
	 */
	private $images;

	/**
	 * @var int
	 */
	private $attendance;

	/**
	 * @var int
	 */
	private $reviews;

	/**
	 * @var string
	 */
	private $tag;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $website;

	/**
	 * @var ArrayCollection
	 */
	private $tickets;

	/**
	 * @var int
	 */
	private $cancelled;

	/**
	 * @var ArrayCollection
	 */
	private $tags;

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
	 * @param string $title
	 */
	public function setTitle( $title )
	{
		$this->title = $title;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param ArrayCollection $artists
	 */
	public function setArtists( ArrayCollection $artists )
	{
		$this->artists = $artists;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getArtists()
	{
		return $this->artists;
	}

	/**
	 * @param string $headliner
	 */
	public function setHeadliner( $headliner )
	{
		$this->headliner = $headliner;
	}

	/**
	 * @return string
	 */
	public function getHeadliner()
	{
		return $this->headliner;
	}

	/**
	 * @param Venue $venue
	 */
	public function setVenue( Venue $venue )
	{
		$this->venue = $venue;
	}

	/**
	 * @return Venue
	 */
	public function getVenue()
	{
		return $this->venue;
	}

	/**
	 * @param string $startDate
	 */
	public function setStartDate( $startDate )
	{
		$this->startDate = $startDate;
	}

	/**
	 * @return string
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}

	/**
	 * @param string $description
	 */
	public function setDescription( $description )
	{
		$this->description = $description;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param ArrayCollection $images
	 */
	public function setImages( ArrayCollection $images )
	{
		$this->images = $images;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param int $attendance
	 */
	public function setAttendance( $attendance )
	{
		$this->attendance = $attendance;
	}

	/**
	 * @return int
	 */
	public function getAttendance()
	{
		return $this->attendance;
	}

	/**
	 * @param int $reviews
	 */
	public function setReviews( $reviews )
	{
		$this->reviews = $reviews;
	}

	/**
	 * @return int
	 */
	public function getReviews()
	{
		return $this->reviews;
	}

	/**
	 * @param string $tag
	 */
	public function setTag( $tag )
	{
		$this->tag = $tag;
	}

	/**
	 * @return string
	 */
	public function getTag()
	{
		return $this->tag;
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
	 * @param string $website
	 */
	public function setWebsite( $website )
	{
		$this->website = $website;
	}

	/**
	 * @return string
	 */
	public function getWebsite()
	{
		return $this->website;
	}

	/**
	 * @param ArrayCollection $tickets
	 */
	public function setTickets( ArrayCollection $tickets )
	{
		$this->tickets = $tickets;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getTickets()
	{
		return $this->tickets;
	}

	/**
	 * @param int $cancelled
	 */
	public function setCancelled( $cancelled )
	{
		$this->cancelled = $cancelled;
	}

	/**
	 * @return int
	 */
	public function getCancelled()
	{
		return $this->cancelled;
	}

	/**
	 * @param ArrayCollection $tags
	 */
	public function setTags( ArrayCollection $tags )
	{
		$this->tags = $tags;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getTags()
	{
		return $this->tags;
	}
}
