<?php
namespace Lertify\Lastfm\Api\Data\Library;

class Artist extends \Lertify\Lastfm\Api\Data\Artist
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
}
