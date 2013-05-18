<?php
namespace Lertify\Lastfm\Api\Data;

use DateTime;

class Event
{
	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $title;

	/**
	 * @var string
	 */
	protected $description;

	/**
	 * @var int
	 */
	protected $attendance;

	/**
	 * @var int
	 */
	protected $reviews;

	/**
	 * @var string
	 */
	protected $tag;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var string
	 */
	protected $website;

	/**
	 * @var int
	 */
	protected $cancelled;

	/**
	 * @var \DateTime
	 */
	protected $startDate;

	/**
	 * @var \DateTime
	 */
	protected $endDate;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Artist[]
	 */
	protected $artists;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Artist
	 */
	protected $headliner;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Venue
	 */
	protected $venue;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $images;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $tickets;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $tags;

	/**
	 * @param int $id
	 * @return \Lertify\Lastfm\Api\Data\Event
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
	 * @param string $title
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setTitle( $title )
	{
		$this->title = $title;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @param string $description
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setDescription( $description )
	{
		$this->description = $description;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @param int $attendance
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setAttendance( $attendance )
	{
		$this->attendance = $attendance;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setReviews( $reviews )
	{
		$this->reviews = $reviews;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setTag( $tag )
	{
		$this->tag = $tag;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setUrl( $url )
	{
		$this->url = $url;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setWebsite( $website )
	{
		$this->website = $website;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getWebsite()
	{
		return $this->website;
	}

	/**
	 * @param int $cancelled
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setCancelled( $cancelled )
	{
		$this->cancelled = $cancelled;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCancelled()
	{
		return $this->cancelled;
	}

	/**
	 * @param \DateTime $StartDate
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setStartDate( DateTime $StartDate )
	{
		$this->startDate = $StartDate;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStartDate()
	{
		return $this->startDate;
	}

	/**
	 * @param \DateTime $EndDate
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setEndDate( DateTime $EndDate )
	{
		$this->endDate = $EndDate;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getEndDate()
	{
		return $this->endDate;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Artists
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setArtists( ArrayCollection $Artists )
	{
		$this->artists = $Artists;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Artist[]
	 */
	public function getArtists()
	{
		return $this->artists;
	}

	/**
	 * @param string $headliner
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setHeadliner( $headliner )
	{
		$this->headliner = $headliner;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getHeadliner()
	{
		return $this->headliner;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Venue $venue
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setVenue( Venue $venue )
	{
		$this->venue = $venue;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Venue
	 */
	public function getVenue()
	{
		return $this->venue;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Images
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setImages( ArrayCollection $Images )
	{
		$this->images = $Images;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Tickets
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setTickets( ArrayCollection $Tickets )
	{
		$this->tickets = $Tickets;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTickets()
	{
		return $this->tickets;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Tags
	 * @return \Lertify\Lastfm\Api\Data\Event
	 */
	public function setTags( ArrayCollection $Tags )
	{
		$this->tags = $Tags;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTags()
	{
		return $this->tags;
	}
}
