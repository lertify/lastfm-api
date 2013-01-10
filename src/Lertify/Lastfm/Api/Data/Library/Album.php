<?php
namespace Lertify\Lastfm\Api\Data\Library;

class Album extends \Lertify\Lastfm\Api\Data\Album
{
	/**
	 * @var int
	 */
	private $tagcount;

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
	 * @param Artist $Artist
	 */
	public function setArtist( Artist $Artist )
	{
		$this->artist = $Artist;
	}

	/**
	 * @return Artist
	 */
	public function getArtist()
	{
		return $this->artist;
	}
}
