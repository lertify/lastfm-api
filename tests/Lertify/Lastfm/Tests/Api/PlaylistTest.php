<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class PlaylistTest extends Setup
{
	public function testAddTrack()
	{
		$status = $this->lastfm->playlist()->addTrack( $GLOBALS['tests_playlist_id'], 'Feel So Close', 'Calvin Harris', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testCreate()
	{
		$Playlist = $this->lastfm->playlist()->create( $GLOBALS['auth_session_key'], 'Some time', 'Some descr' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\Playlist', $Playlist, 'Playlist is not an instance of Data\Playlist\Playlist!' );

		$PlaylistImages = $Playlist->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $PlaylistImages, 'PlaylistImages are not an instance of Data\ArrayCollection!' );

		$PlaylistOwner = $Playlist->getUser();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\User', $PlaylistOwner, 'PlaylistOwner is not an instance of Data\Playlist\User!' );

		$Playlist = $this->lastfm->playlist()->create( $GLOBALS['auth_session_key'], null, null );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\Playlist', $Playlist, 'Playlist is not an instance of Data\Playlist\Playlist!' );

		$PlaylistImages = $Playlist->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $PlaylistImages, 'PlaylistImages are not an instance of Data\ArrayCollection!' );

		$PlaylistOwner = $Playlist->getUser();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\User', $PlaylistOwner, 'PlaylistOwner is not an instance of Data\Playlist\User!' );
	}
}
