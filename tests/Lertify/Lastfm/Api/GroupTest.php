<?php
namespace Lertify\Lastfm\Tests\Api;

class GroupTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testGetHype()
	{
		$WeeklyArtistChart = $this->lastfm->group()->getHype( 'radiohead' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyArtistChart, 'WeeklyArtistChart is not an instance of Data\ArrayCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Group\Artist */
		foreach ( $WeeklyArtistChart as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Group\Artist', $Artist, 'Artist is not an instance of Data\Group\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetMembers()
	{
		$Members = $this->lastfm->group()->getMembers( 'radiohead' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Members, 'Members are not an instance of Data\PagedCollection!' );

		/** @var $User \Lertify\Lastfm\Api\Data\Group\User */
		foreach ( $Members->getPage( 1 ) as $User )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Group\User', $User, 'User is not an instance of Data\Group\User!' );

			$UserImages = $User->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $UserImages, 'UserImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetWeeklyAlbumChart()
	{
		$WeeklyAlbumChart = $this->lastfm->group()->getWeeklyAlbumChart( 'radiohead' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyAlbumChart, 'WeeklyAlbumChart is not an instance of Data\ArrayCollection!' );

		/** @var $Album \Lertify\Lastfm\Api\Data\Group\Album */
		foreach ( $WeeklyAlbumChart as $Album )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Group\Album', $Album, 'Album is not an instance of Data\Group\Album!' );

			$Artist = $Album->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Group\Artist', $Artist, 'Album is not an instance of Data\Group\Artist!' );
		}
	}

	public function testGetWeeklyArtistChart()
	{
		$WeeklyArtistChart = $this->lastfm->group()->getWeeklyArtistChart( 'radiohead' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyArtistChart, 'WeeklyArtistChart is not an instance of Data\ArrayCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Group\Artist */
		foreach ( $WeeklyArtistChart as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Group\Artist', $Artist, 'Artist is not an instance of Data\Group\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetWeeklyChartList()
	{
		$WeeklyChartList = $this->lastfm->group()->getWeeklyChartList( 'radiohead' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyChartList, 'WeeklyChartList is not an instance of Data\ArrayCollection!' );

		/** @var $Chart \Lertify\Lastfm\Api\Data\Group\Chart */
		foreach ( $WeeklyChartList as $Chart )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Group\Chart', $Chart, 'Chart is not an instance of Data\Group\Chart!' );
		}
	}

	public function testGetWeeklyTrackChart()
	{
		$WeeklyTrackChart = $this->lastfm->group()->getWeeklyTrackChart( 'radiohead' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $WeeklyTrackChart, 'WeeklyTrackChart is not an instance of Data\ArrayCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Group\Track */
		foreach ( $WeeklyTrackChart as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Group\Track', $Track, 'Track is not an instance of Data\Group\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages is not an instance of Data\ArrayCollection!' );
		}
	}
}
