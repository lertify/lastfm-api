<?php
namespace Lertify\Lastfm\Api\Data\Library;

class Track extends \Lertify\Lastfm\Api\Data\Track
{
	/**
	 * @var int
	 */
	private $tagcount;

	/**
	 * @var string
	 */
	private $albumName;

	/**
	 * @var int
	 */
	private $albumPosition;

	/**
	 * @param int $tagcount
	 */
	public function setTagcount( $tagcount )
	{
		$this->tagcount = $tagcount;
	}

	/**
	 * @return int
	 */
	public function getTagcount()
	{
		return $this->tagcount;
	}

	/**
	 * @param string $albumName
	 */
	public function setAlbumName( $albumName )
	{
		$this->albumName = $albumName;
	}

	/**
	 * @return string
	 */
	public function getAlbumName()
	{
		return $this->albumName;
	}

	/**
	 * @param int $albumPosition
	 */
	public function setAlbumPosition( $albumPosition )
	{
		$this->albumPosition = $albumPosition;
	}

	/**
	 * @return int
	 */
	public function getAlbumPosition()
	{
		return $this->albumPosition;
	}
}
