<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data;

class Artist
{
	/**
     * @var string
     */
    private $name;

	/**
     * @var string
     */
    private $mbid;

	/**
     * @var string
     */
    private $url;

	/**
	 * @var bool
	 */
	private $streamable;

	/**
	 * @var ArrayCollection
	 */
	private $images;

	/**
	 * @var int
	 */
	private $playcount;

	/**
	 * @var int
	 */
	private $listeners;

	/**
	 * @var int
	 */
	private $percentageChange;

	/**
	 * @var int
	 */
	private $rank;

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
     * @param string $mbid
     */
    public function setMbid( $mbid )
    {
        $this->mbid = $mbid;
    }

    /**
     * @return string
     */
    public function getMbid()
    {
        return $this->mbid;
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
	 * @param bool $streamable
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;
	}

	/**
	 * @return bool
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param ArrayCollection $Images
	 */
	public function setImages( $Images )
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
	 * @param int $percentageChange
	 */
	public function setPercentageChange( $percentageChange )
	{
		$this->percentageChange = $percentageChange;
	}

	/**
	 * @return int
	 */
	public function getPercentageChange()
	{
		return $this->percentageChange;
	}

	/**
	 * @param int $rank
	 */
	public function setRank( $rank )
	{
		$this->rank = $rank;
	}

	/**
	 * @return int
	 */
	public function getRank()
	{
		return $this->rank;
	}
}
