<?php
namespace Lertify\Lastfm\Tests\Api;

class LibraryTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testAddAlbum()
	{
		$status = $this->lastfm->library()->addAlbum( 'Coldplay', 'X&Y', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testAddArtist()
	{
		$status = $this->lastfm->library()->addArtist( 'Calvin Harris', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testAddTrack()
	{
		$status = $this->lastfm->library()->addTrack( 'Calvin Harris', 'We\'ll Be Coming Back', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testGetAlbums()
	{
		$Albums = $this->lastfm->library()->getAlbums( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Albums, 'Albums are not an instance of Data\PagedCollection!' );

		/** @var $Album \Lertify\Lastfm\Api\Data\Library\Album */
		foreach ( $Albums->getPage( 1 ) as $Album )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Library\Album', $Album, 'Album is not an instance of Data\Library\Album!' );

			$Artist = $Album->getArtist();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Library\Artist', $Artist, 'Artist is not an instance of Data\Library\Artist!' );

			$AlbumImages = $Album->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $AlbumImages, 'AlbumImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetArtists()
	{
		$Artists = $this->lastfm->library()->getArtists( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Artists, 'Albums are not an instance of Data\PagedCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Library\Artist */
		foreach ( $Artists->getPage( 1 ) as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Library\Artist', $Artist, 'Artist is not an instance of Data\Library\Artist!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testGetTracks()
	{
		$Tracks = $this->lastfm->library()->getTracks( $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of Data\PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Library\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Library\Track', $Track, 'Track is not an instance of Data\Library\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages are not an instance of Data\ArrayCollection!' );
		}
	}

	public function testRemoveAlbum()
	{
		$status = $this->lastfm->library()->removeAlbum( 'Coldplay', 'X&Y', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testRemoveArtist()
	{
		$status = $this->lastfm->library()->removeArtist( 'Calvin Harris', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testRemoveScrobble()
	{
		$status = $this->lastfm->library()->removeScrobble( 'The Offspring', 'All Along', strtotime( '16 Aug 2012' ), $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testRemoveTrack()
	{
		$status = $this->lastfm->library()->removeTrack( 'Paramore', 'Ignorance', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}
}
