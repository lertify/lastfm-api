<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

class AlbumResults extends Results
{
	/**
	 * @JMS\Type("Lertify\Lastfm\Api\Data\Album\AlbumsCollection")
	 * @var \Lertify\Lastfm\Api\Data\Album\AlbumsCollection
	 */
	protected $albummatches;

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\AlbumsCollection
	 */
	public function getAlbummatches()
	{
		return $this->albummatches;
	}
}