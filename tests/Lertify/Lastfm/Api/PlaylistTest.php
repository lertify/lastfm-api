<?php
/**
 * @author   Eugene Serkin <jeserkin@gmail.com>
 * @version  $Id:$
 */
namespace Lertify\Lastfm\Tests\Api;

class PlaylistTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testAddTrack()
	{
		$status = $this->lastfm->playlist()->addTrack( $GLOBALS['tests_playlist_id'], 'Feel So Close', 'Calvin Harris', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	public function testCreate()
	{
		$Playlist = $this->lastfm->playlist()->create( 'Some time', 'Some descr', $GLOBALS['auth_session_key'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\Playlist', $Playlist, 'Playlist is not an instance of Data\Playlist\Playlist!' );

		$PlaylistImages = $Playlist->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $PlaylistImages, 'PlaylistImages are not an instance of Data\ArrayCollection!' );

		$PlaylistOwner = $Playlist->getUser();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\User', $PlaylistOwner, 'PlaylistOwner is not an instance of Data\Playlist\User!' );

		$Playlist = $this->lastfm->playlist()->create( null, null, $GLOBALS['auth_session_key'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\Playlist', $Playlist, 'Playlist is not an instance of Data\Playlist\Playlist!' );

		$PlaylistImages = $Playlist->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $PlaylistImages, 'PlaylistImages are not an instance of Data\ArrayCollection!' );

		$PlaylistOwner = $Playlist->getUser();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Playlist\User', $PlaylistOwner, 'PlaylistOwner is not an instance of Data\Playlist\User!' );
	}
}
