<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Album;

class Shout extends \Lertify\Lastfm\Api\Data\Shout
{
	/**
	 * @var string
	 */
	private $album;

	/**
	 * @param string $album
	 */
	public function setAlbum( $album )
	{
		$this->album = $album;
	}

	/**
	 * @return string
	 */
	public function getAlbum()
	{
		return $this->album;
	}
}
