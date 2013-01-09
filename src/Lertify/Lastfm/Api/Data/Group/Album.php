<?php
namespace Lertify\Lastfm\Api\Data\Group;

use Lertify\Lastfm\Api\Data\Group\Artist;

class Album extends \Lertify\Lastfm\Api\Data\Artist\Album
{
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
