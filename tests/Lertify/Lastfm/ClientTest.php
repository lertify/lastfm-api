<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Tests;

class ClientTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testApi()
	{
		$AlbumService = $this->lastfm->api( 'album' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Album', $AlbumService, 'AlbumService is not of Api\Album type!' );

		$AlbumService = $this->lastfm->album();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Album', $AlbumService, 'AlbumService is not of Api\Album type!' );

		$AuthService = $this->lastfm->api( 'auth' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Auth', $AuthService, 'AuthService is not of Api\Album type!' );

		$AuthService = $this->lastfm->auth();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Auth', $AuthService, 'AuthService is not of Api\Album type!' );

		$ArtistService = $this->lastfm->api( 'artist' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Artist', $ArtistService, 'ArtistService is not of Api\Artist type!' );

		$ArtistService = $this->lastfm->artist();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Artist', $ArtistService, 'ArtistService is not of Api\Artist type!' );

		$ChartService = $this->lastfm->api( 'chart' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Chart', $ChartService, 'ChartService is not of Api\Chart type!' );

		$ChartService = $this->lastfm->chart();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Chart', $ChartService, 'ChartService is not of Api\Chart type!' );

		$EventService = $this->lastfm->api( 'event' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Event', $EventService, 'EventService is not of Api\Event type!' );

		$EventService = $this->lastfm->event();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Event', $EventService, 'EventService is not of Api\Event type!' );

		$GeoService = $this->lastfm->api( 'geo' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Geo', $GeoService, 'GeoService is not of Api\Geo type!' );

		$GeoService = $this->lastfm->geo();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Geo', $GeoService, 'GeoService is not of Api\Geo type!' );

		$GroupService = $this->lastfm->api( 'group' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Group', $GroupService, 'GroupService is not of Api\Group type!' );

		$GroupService = $this->lastfm->group();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Group', $GroupService, 'GroupService is not of Api\Group type!' );
	}

	/**
	 * @throws \Exception
	 */
	public function testGetConfiguration()
	{
		throw new \Exception( 'TODO Implement Me' );
	}
}
