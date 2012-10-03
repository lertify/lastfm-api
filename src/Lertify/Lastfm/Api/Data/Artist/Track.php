<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Artist;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class Track extends \Lertify\Lastfm\Api\Data\Track
{
	/**
	 * @var int
	 */
	private $playcount;

	/**
	 * @var int
	 */
	private $listeners;

	/**
	 * @var ArrayCollection
	 */
	private $images;

	/**
	 * @param int $playcount
	 */
	public function setPlaycount( $playcount )
	{
		$this->playcount = $playcount;
	}

	/**
	 * @return int
	 */
	public function getPlaycount()
	{
		return $this->playcount;
	}

	/**
	 * @param int $listeners
	 */
	public function setListeners( $listeners )
	{
		$this->listeners = $listeners;
	}

	/**
	 * @return int
	 */
	public function getListeners()
	{
		return $this->listeners;
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
