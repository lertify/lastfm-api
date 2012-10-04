<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Event;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class User
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $realName;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var ArrayCollection
	 */
	private $images;

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
	 * @param string $realName
	 */
	public function setRealName( $realName )
	{
		$this->realName = $realName;
	}

	/**
	 * @return string
	 */
	public function getRealName()
	{
		return $this->realName;
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
	 * @param ArrayCollection $Images
	 */
	public function setImages( ArrayCollection $Images )
	{
		$this->images = $Images;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}
}
