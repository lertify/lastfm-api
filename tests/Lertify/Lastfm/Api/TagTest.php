<?php
namespace Lertify\Lastfm\Tests\Api;

class TagTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testGetInfo()
	{
		$Tag = $this->lastfm->tag()->getInfo( 'pop' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Tag', $Tag, 'Tag is not an instance of Data\Tag\Tag!' );
	}

	public function testGetSimilar()
	{
		$Tags = $this->lastfm->tag()->getSimilar( 'disco' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags are not an instance of Data\ArrayCollection!' );

		/** @var $Tag \Lertify\Lastfm\Api\Data\Tag\Tag */
		foreach ( $Tags as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Tag', $Tag, 'Tag is not an instance of Data\Tag\Tag!' );
		}
	}

	public function testGetTopAlbums()
	{
		$Albums = $this->lastfm->tag()->getTopAlbums( 'pop' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Albums, 'Albums are not an instance of Data\PagedCollection!' );

		/** @var $Album \Lertify\Lastfm\Api\Data\Tag\Album */
		foreach ( $Albums->getPage( 1 ) as $Album )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Album', $Album, 'Album is not an instance of Data\Tag\Album!' );

			$Artist = $Album->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Artist', $Artist, 'Artist is not an instance of Data\Tag\Artist!' );

			$AlbumImages = $Album->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $AlbumImages, 'AlbumImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetTopArtists()
	{
		$Artists = $this->lastfm->tag()->getTopArtists( 'disco' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Artists are not an instance of Data\PagedCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Tag\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Artist', $Artist, 'Artist is not an instance of Data\Tag\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetTopTags()
	{
		$TopTags = $this->lastfm->tag()->getTopTags();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTags, 'TopTags are not an instance of Data\ArrayCollection!' );

		foreach ( $TopTags as $TopTag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Tag', $TopTag, 'TopTag is not an instance of Data\Tag\Tag!' );
		}
	}

	public function testGetTopTracks()
	{
		$TopTracks = $this->lastfm->tag()->getTopTracks( 'trance' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $TopTracks, 'TopTracks are not an instance of Data\PagedCollection!' );

		/** @var $TopTrack \Lertify\Lastfm\Api\Data\Tag\Track */
		foreach ( $TopTracks->getPage( 1 ) as $TopTrack )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Track', $TopTrack, 'TopTrack is not an instance of Data\Tag\Track!' );

			$TrackImages = $TopTrack->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetWeeklyChartList()
	{
		$ChartList = $this->lastfm->tag()->getWeeklyChartList( 'dub' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ChartList, 'ChartList are not an instance of Data\ArrayCollection!' );

		foreach ( $ChartList as $Chart )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Chart', $Chart, 'Chart is not an instance of Data\Tag\Chart!' );
		}
	}

	public function testGetWeeklyArtistChart()
	{
		$ArtistsChart = $this->lastfm->tag()->getWeeklyArtistChart( 'dub' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistsChart, 'ArtistsChart is not an instance of Data\ArrayCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Tag\Artist */
		foreach ( $ArtistsChart as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Artist', $Artist, 'Artist is not an instance of Data\Tag\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testSearch()
	{
		$Tags = $this->lastfm->tag()->search( 'dub' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tags, 'Tags are not an instance of Data\PagedCollection!' );

		foreach ( $Tags->getPage( 1 ) as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tag\Tag', $Tag, 'Tag is not an instance of Data\Tag\Tag!' );
		}
	}
}
