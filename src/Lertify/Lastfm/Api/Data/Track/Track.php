<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Track;

class Track
{
	/**
	 * @var int
	 */
	private $rank;

	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var int (seconds)
	 */
	private $duration;

	/**
	 * @var string
	 */
	private $mbId;

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var bool
	 */
	private $streamable = false;

	/**
	 * @var bool
	 */
	private $streamableFulltrack = false;

	/**
	 * @var string
	 */
	private $artistName;

	/**
	 * @var string
	 */
	private $artistMbId;

	/**
	 * @var string
	 */
	private $artistUrl;

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
	 * @param int $duration
	 */
	public function setDuration( $duration )
	{
		$this->duration = $duration;
	}

	/**
	 * @return int
	 */
	public function getDuration()
	{
		return $this->duration;
	}

	/**
	 * @param string $mbId
	 */
	public function setMbId( $mbId )
	{
		$this->mbId = $mbId;
	}

	/**
	 * @return string
	 */
	public function getMbId()
	{
		return $this->mbId;
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
	 * @param boolean $streamable
	 */
	public function setStreamable( $streamable )
	{
		$this->streamable = $streamable;
	}

	/**
	 * @return boolean
	 */
	public function getStreamable()
	{
		return $this->streamable;
	}

	/**
	 * @param boolean $streamableFulltrack
	 */
	public function setStreamableFulltrack( $streamableFulltrack )
	{
		$this->streamableFulltrack = $streamableFulltrack;
	}

	/**
	 * @return boolean
	 */
	public function getStreamableFulltrack()
	{
		return $this->streamableFulltrack;
	}

	/**
	 * @param string $artistName
	 */
	public function setArtistName( $artistName )
	{
		$this->artistName = $artistName;
	}

	/**
	 * @return string
	 */
	public function getArtistName()
	{
		return $this->artistName;
	}

	/**
	 * @param string $artistMbId
	 */
	public function setArtistMbId( $artistMbId )
	{
		$this->artistMbId = $artistMbId;
	}

	/**
	 * @return string
	 */
	public function getArtistMbId()
	{
		return $this->artistMbId;
	}

	/**
	 * @param string $artistUrl
	 */
	public function setArtistUrl( $artistUrl )
	{
		$this->artistUrl = $artistUrl;
	}

	/**
	 * @return string
	 */
	public function getArtistUrl()
	{
		return $this->artistUrl;
	}
}
