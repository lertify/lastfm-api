<?php
namespace Lertify\Lastfm\Api\Data;

class Artist extends AbstractData
{
	/**
     * @var string
     */
    protected $name;

	/**
     * @var string
     */
    protected $mbid;

	/**
     * @var string
     */
    protected $url;

	/**
	 * @var bool
	 */
	protected $streamable;

	/**
	 * @var int
	 */
	protected $playcount;

	/**
	 * @var int
	 */
	protected $listeners;

	/**
	 * @var int
	 */
	protected $percentageChange;

	/**
	 * @var int
	 */
	protected $rank;

	/**
	 * @var \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	protected $images;

	/**
     * @param string $name
	 * @return \Lertify\Lastfm\Api\Data\Artist
     */
    public function setName( $name )
    {
        $this->name = $name;

	    return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Artist
     */
    public function setMbid( $mbid )
    {
        $this->mbid = $mbid;

	    return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Artist
     */
    public function setUrl( $url )
    {
        $this->url = $url;

	    return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Artist
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;

		return $this;
	}

	/**
	 * @return bool
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param int $listeners
	 * @return \Lertify\Lastfm\Api\Data\Artist
	 */
	public function setListeners( $listeners )
	{
		$this->listeners = $listeners;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Artist
	 */
	public function setPlaycount( $playcount )
	{
		$this->playcount = $playcount;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Artist
	 */
	public function setPercentageChange( $percentageChange )
	{
		$this->percentageChange = $percentageChange;

		return $this;
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
	 * @return \Lertify\Lastfm\Api\Data\Artist
	 */
	public function setRank( $rank )
	{
		$this->rank = $rank;

		return $this;
	}

	/**
	 * @return int
	 */
	public function getRank()
	{
		return $this->rank;
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\ArrayCollection $Images
	 * @return \Lertify\Lastfm\Api\Data\Artist
	 */
	public function setImages( ArrayCollection $Images )
	{
		$this->images = $Images;

		return $this;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getImages()
	{
		return $this->images;
	}
}
