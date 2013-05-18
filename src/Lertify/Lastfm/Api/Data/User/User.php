<?php
namespace Lertify\Lastfm\Api\Data\User;

use Lertify\Lastfm\Api\Data\User\Track,

	Lertify\Lastfm\Api\Data\AbstractData,
	Lertify\Lastfm\Api\Data\ArrayCollection,

	DateTime;

class User extends AbstractData
{
	/**
	 * @var string
	 */
	protected $name;

	/**
	 * @var string
	 */
	protected $realname;

	/**
	 * @var string
	 */
	protected $url;

	/**
	 * @var int
	 */
	protected $id;

	/**
	 * @var string
	 */
	protected $country;

	/**
	 * @var int
	 */
	protected $age;

	/**
	 * @var string
	 */
	protected $gender;

	/**
	 * @var bool
	 */
	protected $subscriber;

	/**
	 * @var int
	 */
	protected $playcount;

	/**
	 * @var int
	 */
	protected $playlists;

	/**
	 * @var int
	 */
	protected $bootstrap;

	/**
	 * @var string
	 */
	protected $type;

	/**
	 * @var float
	 */
	protected $match;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $images;

	/**
	 * @var \DateTime
	 */
	protected $registeredAt;

	/**
	 * @var \Lertify\Lastfm\Api\Data\Track
	 */
	protected $recentTrack;

	/**
	 * @param string $name
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setName( $name )
	{
		$this->name = $name;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $realname
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setRealname( $realname )
	{
		$this->realname = $realname;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getRealname()
	{
		return $this->realname;
	}

	/**
	 * @param string $url
	 * @return \Lertify\Lastfm\Api\Data\User\User
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
	 * @param int $id
	 * @return \Lertify\Lastfm\Api\Data\User\User
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
	 * @param string $country
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setCountry( $country )
	{
		$this->country = $country;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCountry()
	{
		return $this->country;
	}

	/**
	 * @param int $age
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setAge( $age )
	{
		$this->age = $age;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getAge()
	{
		return $this->age;
	}

	/**
	 * @param string $gender
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setGender( $gender )
	{
		$this->gender = $gender;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * @param bool $subscriber
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setSubscriber( $subscriber )
	{
		$this->subscriber = $subscriber;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getSubscriber()
	{
		return $this->subscriber;
	}

	/**
	 * @param int $playcount
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setPlaycount( $playcount )
	{
		$this->playcount = $playcount;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPlaycount()
	{
		return $this->playcount;
	}

	/**
	 * @param int $playlists
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setPlaylists( $playlists )
	{
		$this->playlists = $playlists;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPlaylists()
	{
		return $this->playlists;
	}

	/**
	 * @param int $bootstrap
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setBootstrap( $bootstrap )
	{
		$this->bootstrap = $bootstrap;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getBootstrap()
	{
		return $this->bootstrap;
	}

	/**
	 * @param string $type
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setType( $type )
	{
		$this->type = $type;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param float $match
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setMatch( $match )
	{
		$this->match = $match;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getMatch()
	{
		return $this->match;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Images
	 * @return \Lertify\Lastfm\Api\Data\User\User
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
	 * @param \DateTime $RegisteredAt
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setRegisteredAt( DateTime $RegisteredAt )
	{
		$this->registeredAt = $RegisteredAt;

		return $this;
	}

	/**
	 * @return \DateTime
	 */
	public function getRegisteredAt()
	{
		return $this->registeredAt;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\User\Track $Track
	 * @return \Lertify\Lastfm\Api\Data\User\User
	 */
	public function setRecentTrack( Track $Track )
	{
		$this->recentTrack = $Track;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Track
	 */
	public function getRecentTrack()
	{
		return $this->recentTrack;
	}
}