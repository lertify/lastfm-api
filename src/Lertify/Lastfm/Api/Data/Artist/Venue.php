<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Artist;

use Lertify\Lastfm\Api\Data\ArrayCollection;

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
	 * @var ArrayCollection
	 */
	private $images;

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
	 * @param string $city
	 */
	public function setCity( $city )
	{
		$this->city = $city;
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
	 */
	public function setCountry( $country )
	{
		$this->country = $country;
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
	 */
	public function setStreet( $street )
	{
		$this->street = $street;
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
	 */
	public function setPostalcode( $postalcode )
	{
		$this->postalcode = $postalcode;
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
	 */
	public function setLatitude( $latitude )
	{
		$this->latitude = $latitude;
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
	 */
	public function setLongitude( $longitude )
	{
		$this->longitude = $longitude;
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
	 * @param string $phonenumber
	 */
	public function setPhonenumber( $phonenumber )
	{
		$this->phonenumber = $phonenumber;
	}

	/**
	 * @return string
	 */
	public function getPhonenumber()
	{
		return $this->phonenumber;
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
}
