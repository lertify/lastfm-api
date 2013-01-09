<?php
namespace Lertify\Lastfm\Api\Data\Geo;

class Metro
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $country;

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
}
