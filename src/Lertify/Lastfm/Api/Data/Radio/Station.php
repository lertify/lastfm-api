<?php
namespace Lertify\Lastfm\Api\Data\Radio;

class Station
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $url;

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
}
