<?php
namespace Lertify\Lastfm\Api\Data;

class Tag
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
	 * @var int
	 */
	private $count;

	/**
	 * @param string $name
	 * @return \Lertify\Lastfm\Api\Data\Tag
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
	 * @param string $url
	 * @return \Lertify\Lastfm\Api\Data\Tag
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
	 * @param int $count
	 * @return \Lertify\Lastfm\Api\Data\Tag
	 */
	public function setCount( $count )
	{
		$this->count = $count;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}
}
