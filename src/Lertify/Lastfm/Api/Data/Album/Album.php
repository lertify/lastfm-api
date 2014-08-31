<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS,

    DateTime;

class Album
{
	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $name;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $artist;

	/**
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $id;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $mbid;

	/**
	 * @JMS\Type("string")
	 * @var string
	 */
	protected $url;

	/**
	 * @JMS\Accessor(setter="setReleasedate", getter="getReleasedate")
	 * @JMS\Type("string")
	 * @var \DateTime
	 */
	protected $releasedate;

	/**
     * @JMS\Type("Lertify\Lastfm\Api\Data\Album\ImagesCollection")
	 * @JMS\XmlList(inline=true, entry="image")
	 * @var \Lertify\Lastfm\Api\Data\Album\ImagesCollection
     */
	protected $images;

	/**
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $listeners;

	/**
	 * @JMS\Type("integer")
	 * @var int
	 */
	protected $playcount;

	/**
     * @JMS\Type("Lertify\Lastfm\Api\Data\Album\TracksCollection")
	 * @var \Lertify\Lastfm\Api\Data\Album\TracksCollection
     */
	protected $tracks;

	/**
	 * @JMS\Type("Lertify\Lastfm\Api\Data\Album\TagsCollection")
	 * @var \Lertify\Lastfm\Api\Data\Album\TagsCollection
	 */
	protected $toptags;

	/**
	 * @JMS\Type("Lertify\Lastfm\Api\Data\Album\Wiki")
	 * @var \Lertify\Lastfm\Api\Data\Album\Wiki
	 */
	protected $wiki;

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return string
	 */
	public function getArtist()
	{
		return $this->artist;
	}

	/**
	 * @return int
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getMbid()
	{
		return $this->mbid;
	}

	/**
	 * @return string
	 */
	public function getUrl()
	{
		return $this->url;
	}

	/**
	 * @param string $releaseDate
	 */
	public function setReleasedate( $releaseDate )
	{
		$this->releasedate = new DateTime( trim( $releaseDate ) );
	}

	/**
	 * @return \DateTime
	 */
	public function getReleasedate()
	{
		return $this->releasedate;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\ImagesCollection
	 */
	public function getImages()
	{
		return $this->images;
	}

	/**
	 * @return int
	 */
	public function getListeners()
	{
		return $this->listeners;
	}

	/**
	 * @return int
	 */
	public function getPlaycount()
	{
		return $this->playcount;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\TracksCollection
	 */
	public function getTracks()
	{
		return $this->tracks;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\TagsCollection
	 */
	public function getToptags()
	{
		return $this->toptags;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\Wiki
	 */
	public function getWiki()
	{
		return $this->wiki;
	}
}