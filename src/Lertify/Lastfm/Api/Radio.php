<?php
/**
 * @author   Eugene Serkin <jeserkin@gmail.com>
 * @version  $Id:$
 */
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Util\Util;

class Radio extends AbstractApi
{
	const
		PREFIX = 'radio.';

	public function getPlaylist( $sk, $discovery = false, $buylinks = false, $speedMltiplier = 1.0, $bitrate = 64, $rtp = false )
	{
		// @todo: No implementation at the moment due to no way to test
	}

	/**
	 * @param string $station
	 * @param string $sk
	 * @param string|null $lang
	 * @return Data\Radio\Station
	 */
	public function tune( $station, $sk, $lang = null )
	{
		// @todo: No implementation at the moment due to no way to test
	}

	/**
	 * @link http://www.last.fm/api/show/radio.search
	 *
	 * @param string $artist
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	public function search( $artist )
	{
		$params = array(
			'name' => $artist,
		);

		$result         = $this->get( self::PREFIX . 'search', $params );
		$resultStations = $result['stations'];

		if ( ! isset( $resultStations['station'] ) )
		{
			throw new NotFoundException( 'No station found for this artist or tag!' );
		}

		if ( isset( $resultStations['station'][0] ) )
		{
			$stations = $resultStations['station'];
		}
		else
		{
			$stations = array( $resultStations['station'] );
		}

		$StationsList = new ArrayCollection();

		foreach ( $stations as $stationRow )
		{
			$Station = new Data\Radio\Station();

			$Station->setName( Util::toSting( $stationRow['name'] ) );
			$Station->setUrl( Util::toSting( $stationRow['url'] ) );

			$StationsList->add( $Station );
		}

		return $StationsList;
	}
}
