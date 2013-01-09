<?php
namespace Lertify\Lastfm\Tests\Api;

class ChartTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testGetHypedArtists()
	{
		$Artists = $this->lastfm->chart()->getHypedArtists();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Artists are not an instance of PagedCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Chart\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Chart\Artist', $Artist, 'Artist is not an instance of Data\Chart\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages is not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetHypedTracks()
	{
		$Tracks = $this->lastfm->chart()->getHypedTracks();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Chart\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Chart\Track', $Track, 'Track is not an instance of Data\Chart\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetLovedTracks()
	{
		$Tracks = $this->lastfm->chart()->getLovedTracks();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Chart\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Chart\Track', $Track, 'Track is not an instance of Data\Chart\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetTopArtists()
	{
		$Artists = $this->lastfm->chart()->getTopArtists();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Artists are not an instance of PagedCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Chart\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Chart\Artist', $Artist, 'Artist is not an instance of Data\Chart\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetTopTags()
	{
		$Tags = $this->lastfm->chart()->getTopTags();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tags, 'Tags are not an instance of PagedCollection!' );

		/** @var $Tag \Lertify\Lastfm\Api\Data\Chart\Tag */
		foreach ( $Tags->getPage( 1 ) as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Chart\Tag', $Tag, 'Tag is not an instance of Data\Chart\Tag!' );
		}
	}

	public function testGetTopTracks()
	{
		$Tracks = $this->lastfm->chart()->getTopTracks();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Chart\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Chart\Track', $Track, 'Track is not an instance of Data\Chart\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}
}
