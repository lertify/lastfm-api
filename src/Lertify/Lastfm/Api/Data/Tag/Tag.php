<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Tag;

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

	/**
	 * @param int $count
	 */
	public function setCount( $count )
	{
		$this->count = $count;
	}

	/**
	 * @return int
	 */
	public function getCount()
	{
		return $this->count;
	}
}
