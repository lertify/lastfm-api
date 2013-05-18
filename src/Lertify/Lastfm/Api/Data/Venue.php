<?php
namespace Lertify\Lastfm\Api\Data;

class Venue
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
	private $city;

	/**
	 * @var string
	 */
	private $country;

	/**
	 * @var string
	 */
	private $street;

	/**
	 * @var int
	 */
	private $postalcode;

	/**
	 * @var float
	 */
	private $latitude;

	/**
	 * @var float
	 */
	private $longitude;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $website;

	/**
	 * @var string
	 */
	private $phonenumber;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	private $images;

	/**
	 * @param int $id
	 * @return \Lertify\Lastfm\Api\Data\Venue
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
	 * @param string $name
	 * @return \Lertify\Lastfm\Api\Data\Venue
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
	 * @param string $city
	 * @return \Lertify\Lastfm\Api\Data\Venue
	 */
	public function setCity( $city )
	{
		$this->city = $city;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getCity()
	{
		return $this->city;
	}

	/**
	 * @param string $country
	 * @return \Lertify\Lastfm\Api\Data\Venue
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
	 * @param string $street
	 * @return \Lertify\Lastfm\Api\Data\Venue
	 */
	public function setStreet( $street )
	{
		$this->street = $street;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @param int $postalcode
	 * @return \Lertify\Lastfm\Api\Data\Venue
	 */
	public function setPostalcode( $postalcode )
	{
		$this->postalcode = $postalcode;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getPostalcode()
	{
		return $this->postalcode;
	}

	/**
	 * @param float $latitude
	 * @return \Lertify\Lastfm\Api\Data\Venue
	 */
	public function setLatitude( $latitude )
	{
		$this->latitude = $latitude;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getLatitude()
	{
		return $this->latitude;
	}

	/**
	 * @param float $longitude
	 * @return \Lertify\Lastfm\Api\Data\Venue
	 */
	public function setLongitude( $longitude )
	{
		$this->longitude = $longitude;

		return $this;
	}

	/**
	 * @return float
	 */
	public function getLongitude()
	{
		return $this->longitude;
	}

	/**
	 * @param string $url
	 * @return \Lertify\Lastfm\Api\Data\Venue
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
	 * @return \Lertify\Lastfm\Api\Data\Venue
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
	 * @param string $phonenumber
	 * @return \Lertify\Lastfm\Api\Data\Venue
	 */
	public function setPhonenumber( $phonenumber )
	{
		$this->phonenumber = $phonenumber;

		return $this;
	}

	/**
	 * @return string
	 */
	public function getPhonenumber()
	{
		return $this->phonenumber;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Images
	 * @return \Lertify\Lastfm\Api\Data\Venue
	 */
	public function setImages( ArrayCollection $Images )
	{
		$this->images = $Images;

		return $this;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}
}
