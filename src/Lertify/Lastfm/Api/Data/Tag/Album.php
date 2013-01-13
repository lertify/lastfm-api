<?php
namespace Lertify\Lastfm\Api\Data\Tag;

class Album extends \Lertify\Lastfm\Api\Data\Album
{
	/**
	 * @param \Lertify\Lastfm\Api\Data\Tag\Artist $Artist
	 */
	public function setArtist( Artist $Artist )
	{
		$this->artist = $Artist;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Tag\Artist
	 */
	public function getArtist()
	{
		return $this->artist;
	}
}
