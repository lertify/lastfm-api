<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id:$
 */
namespace Lertify\Lastfm\Api\Data\Tasteometer;

use Lertify\Lastfm\Api\Data\ArrayCollection;

class Comparison
{
	/**
	 * @var ArrayCollection
	 */
	private $input;

	/**
	 * @var float
	 */
	private $score;

	/**
	 * @var int
	 */
	private $matches;

	/**
	 * @var ArrayCollection
	 */
	private $artists;

	/**
	 * @param ArrayCollection $Input
	 */
	public function setInput( ArrayCollection $Input )
	{
		$this->input = $Input;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getInput()
	{
		return $this->input;
	}

	/**
	 * @param float $score
	 */
	public function setScore( $score )
	{
		$this->score = $score;
	}

	/**
	 * @return float
	 */
	public function getScore()
	{
		return $this->score;
	}

	/**
	 * @param int $matches
	 */
	public function setMatches( $matches )
	{
		$this->matches = $matches;
	}

	/**
	 * @return int
	 */
	public function getMatches()
	{
		return $this->matches;
	}

	/**
	 * @param ArrayCollection $Artists
	 */
	public function setArtists( ArrayCollection $Artists )
	{
		$this->artists = $Artists;
	}

	/**
	 * @return ArrayCollection
	 */
	public function getArtists()
	{
		return $this->artists;
	}
}
