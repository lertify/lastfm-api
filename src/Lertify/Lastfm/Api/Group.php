<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Util\Util,
	Lertify\Lastfm\Api\Data\PagedCollection;

class Group extends AbstractApi
{
	const
		PREFIX = 'group.';

	/**
	 * @link http://www.last.fm/api/show/group.getHype
	 *
	 * @param string $group
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	public function getHype( $group )
	{
		$params = array(
			'group' => $group,
		);

		$result                  = $this->get( self::PREFIX . 'getHype', $params );
		$resultWeeklyArtistChart = $result['weeklyartistchart'];

		if ( ! isset( $resultWeeklyArtistChart['artist'] ) )
		{
			throw new NotFoundException( 'No artists found!' );
		}

		if ( isset( $resultWeeklyArtistChart['artist'][0] ) )
		{
			$artists = $resultWeeklyArtistChart['artist'];
		}
		else
		{
			$artists = array( $resultWeeklyArtistChart['artist'] );
		}

		$ArtistsList = new ArrayCollection();

		foreach ( $artists as $artistRow )
		{
			$Artist = new Data\Group\Artist();

			$Artist->setName( Util::toSting( $artistRow['name'] ) );
			$Artist->setPercentageChange( (int) $artistRow['percentagechange'] );
			$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
			$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
			$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );
			$Artist->setRank( (int) $artistRow['@attr']['rank'] );

			$ArtistImages = new ArrayCollection();

			if ( isset( $artistRow['image'] ) )
			{
				foreach ( $artistRow['image'] as $image )
				{
					$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}
			}

			$Artist->setImages( $ArtistImages );
			$ArtistsList->add( $Artist );
		}

		return $ArtistsList;
	}

	/**
	 * @link http://www.last.fm/api/show/group.getMembers
	 *
	 * @param string $group
	 * @throws NotFoundException
	 * @return PagedCollection
	 */
	public function getMembers( $group )
	{
		$params = array(
			'group' => $group,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );

			$result        = $self->get( Group::PREFIX . 'getMembers', $params );
			$resultMembers = $result['members'];

			if ( ! isset( $resultMembers['user'] ) )
			{
				throw new NotFoundException( 'No users found for this group!' );
			}

			$totalResults = (int) $resultMembers['@attr']['total'];
			$totalPages   = (int) $resultMembers['@attr']['totalPages'];

			if ( isset( $resultMembers['user'][0] ) )
			{
				$users = $resultMembers['user'];
			}
			else
			{
				$users = array( $resultMembers['user'] );
			}

			$List = new ArrayCollection();

			foreach ( $users as $userRow )
			{
				$User = new Data\Group\User();

				$User->setName( Util::toSting( $userRow['name'] ) );
				$User->setRealName( Util::toSting( $userRow['realname'] ) );
				$User->setUrl( Util::toSting( $userRow['url'] ) );

				$UserImages = new ArrayCollection();

				if ( isset( $userRow['image'] ) )
				{
					foreach ( $userRow['image'] as $image )
					{
						$UserImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$User->setImages( $UserImages );

				$List->add( $User );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}

	/**
	 * @link http://www.last.fm/api/show/group.getWeeklyAlbumChart
	 *
	 * @param string $group
	 * @param int|null $from
	 * @param int|null $to
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	public function getWeeklyAlbumChart( $group, $from = null, $to = null )
	{
		$params = array(
			'group' => $group,
			'from'  => $from,
			'to'    => $to,
		);

		$result                 = $this->get( self::PREFIX . 'getWeeklyAlbumChart', $params );
		$resultWeeklyAlbumChart = $result['weeklyalbumchart'];

		if ( ! isset( $resultWeeklyAlbumChart['album'] ) )
		{
			throw new NotFoundException( 'No albums found!' );
		}

		if ( isset( $resultWeeklyAlbumChart['album'][0] ) )
		{
			$albums = $resultWeeklyAlbumChart['album'];
		}
		else
		{
			$albums = array( $resultWeeklyAlbumChart['album'] );
		}

		$AlbumsList = new ArrayCollection();

		foreach ( $albums as $albumRow )
		{
			$Album  = new Data\Group\Album();
			$Artist = new Data\Group\Artist();

			$Artist->setName( Util::toSting( $albumRow['artist']['#text'] ) );
			$Artist->setMbid( Util::toSting( $albumRow['artist']['mbid'] ) );

			$Album->setArtist( $Artist );
			$Album->setName( Util::toSting( $albumRow['name'] ) );
			$Album->setMbid( Util::toSting( $albumRow['mbid'] ) );
			$Album->setPlaycount( (int) $albumRow['playcount'] );
			$Album->setUrl( Util::toSting( $albumRow['url'] ) );
			$Album->setRank( (int) $albumRow['@attr']['rank'] );

			$AlbumsList->add( $Album );
		}

		return $AlbumsList;
	}

	/**
	 * @link http://www.last.fm/api/show/group.getWeeklyArtistChart
	 *
	 * @param string $group
	 * @param int|null $from
	 * @param int|null $to
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	public function getWeeklyArtistChart( $group, $from = null, $to = null )
	{
		$params = array(
			'group' => $group,
			'from'  => $from,
			'to'    => $to,
		);

		$result                  = $this->get( self::PREFIX . 'getWeeklyArtistChart', $params );
		$resultWeeklyArtistChart = $result['weeklyartistchart'];

		if ( ! isset( $resultWeeklyArtistChart['artist'] ) )
		{
			throw new NotFoundException( 'No artists found!' );
		}

		if ( isset( $resultWeeklyArtistChart['artist'][0] ) )
		{
			$artists = $resultWeeklyArtistChart['artist'];
		}
		else
		{
			$artists = array( $resultWeeklyArtistChart['artist'] );
		}

		$ArtistsList = new ArrayCollection();

		foreach ( $artists as $artistRow )
		{
			$Artist = new Data\Group\Artist();

			$Artist->setName( Util::toSting( $artistRow['name'] ) );
			$Artist->setPlaycount( (int) $artistRow['playcount'] );
			$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
			$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
			$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );
			$Artist->setRank( (int) $artistRow['@attr']['rank'] );

			$ArtistImages = new ArrayCollection();

			if ( isset( $artistRow['image'] ) )
			{
				foreach ( $artistRow['image'] as $image )
				{
					$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}
			}

			$Artist->setImages( $ArtistImages );
			$ArtistsList->add( $Artist );
		}

		return $ArtistsList;
	}

	/**
	 * @link http://www.last.fm/api/show/group.getWeeklyChartList
	 *
	 * @param string $group
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	public function getWeeklyChartList( $group )
	{
		$params = array(
			'group' => $group,
		);

		$result                = $this->get( self::PREFIX . 'getWeeklyChartList', $params );
		$resultWeeklychartlist = $result['weeklychartlist'];

		if ( ! isset( $resultWeeklychartlist['chart'] ) )
		{
			throw new NotFoundException( 'No charts found!' );
		}

		if ( isset( $resultWeeklychartlist['chart'][0] ) )
		{
			$charts = $resultWeeklychartlist['chart'];
		}
		else
		{
			$charts = array( $resultWeeklychartlist['chart'] );
		}

		$Charts = new ArrayCollection();

		foreach ( $charts as $chartRow )
		{
			$Chart = new Data\Group\Chart();

			$Chart->setFrom( (int) $chartRow['from'] );
			$Chart->setTo( (int) $chartRow['to'] );

			$Charts->add( $Chart );
		}

		return $Charts;
	}

	/**
	 * @link http://www.last.fm/api/show/group.getWeeklyTrackChart
	 *
	 * @param string $group
	 * @param int|null $from
	 * @param int|null $to
	 * @throws NotFoundException
	 * @return ArrayCollection
	 */
	public function getWeeklyTrackChart( $group, $from = null, $to = null )
	{
		$params = array(
			'group' => $group,
			'from'  => $from,
			'to'    => $to,
		);

		$result                 = $this->get( self::PREFIX . 'getWeeklyTrackChart', $params );
		$resultWeeklytrackchart = $result['weeklytrackchart'];

		if ( ! isset( $resultWeeklytrackchart['track'] ) )
		{
			throw new NotFoundException( 'No tracks found!' );
		}

		if ( isset( $resultWeeklytrackchart['track'][0] ) )
		{
			$tracks = $resultWeeklytrackchart['track'];
		}
		else
		{
			$tracks = array( $resultWeeklytrackchart['track'] );
		}

		$TracksList = new ArrayCollection();

		foreach ( $tracks as $trackRow )
		{
			$Track = new Data\Group\Track();

			$Track->setArtistName( Util::toSting( $trackRow['artist']['#text'] ) );
			$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
			$Track->setName( Util::toSting( $trackRow['name'] ) );
			$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
			$Track->setPlaycount( (int) $trackRow['playcount'] );
			$Track->setUrl( Util::toSting( $trackRow['url'] ) );
			$Track->setRank( (int) $trackRow['@attr']['rank'] );

			$TrackImages = new ArrayCollection();

			if ( isset( $trackRow['image'] ) )
			{
				foreach ( $trackRow['image'] as $image )
				{
					$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}
			}

			$Track->setImages( $TrackImages );
			$TracksList->add( $Track );
		}

		return $TracksList;
	}
}
