<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class RadioTest extends Setup
{
	public function testGetPlaylist()
	{
		$this->lastfm->radio()->getPlaylist( $GLOBALS['auth_session_key'] );
	}

	public function testTune()
	{
		$Stations = $this->lastfm->radio()->search( 'Daft Punk' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Stations, 'Stations are not an instance of Data\ArrayCollection!' );

		/** @var $Station \Lertify\Lastfm\Api\Data\Radio\Station */
		$Station = $Stations->get(0);
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Radio\Station', $Station, 'Station is not an instance of Data\Radio\Station!' );

		$this->lastfm->radio()->tune( $Station->getUrl(), $GLOBALS['auth_session_key'] );
	}

	public function testSearch()
	{
		$Stations = $this->lastfm->radio()->search( 'Daft Punk' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Stations, 'Stations are not an instance of Data\ArrayCollection!' );

		foreach ( $Stations as $Station )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Radio\Station', $Station, 'Station is not an instance of Data\Radio\Station!' );
		}
	}
}
