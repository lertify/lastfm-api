<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\PagedCollection,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Util\Util;

class Chart extends AbstractApi
{
	const
		PREFIX = 'chart.';

	/**
	 * @link http://www.last.fm/api/show/chart.getHypedArtists
	 *
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getHypedArtists()
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $self )
		{
			$params = array(
				'page'  => $page,
				'limit' => $limit,
			);

			$result        = $self->get( Chart::PREFIX . 'getHypedArtists', $params );
			$resultArtists = $result['artists'];

			if ( ! isset( $resultArtists['artist'] ) )
			{
				throw new NotFoundException( 'No hyped artists found!' );
			}

			$totalResults = (int) $resultArtists['@attr']['total'];
			$totalPages   = (int) $resultArtists['@attr']['totalPages'];

			if ( isset( $resultArtists['artist'][0] ) )
			{
				$artists = $resultArtists['artist'];
			}
			else
			{
				$artists = array( $resultArtists['artist'] );
			}

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new Data\Chart\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );
				$Artist->setPercentageChange( (int) $artistRow['percentagechange'] );
				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );

				$ArtistImages = new ArrayCollection();

				if ( isset( $artistRow['image'] ) )
				{
					foreach ( $artistRow['image'] as $image )
					{
						$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Artist->setImages( $ArtistImages );

				$List->add( $Artist );
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
	 * @link http://www.last.fm/api/show/chart.getHypedTracks
	 *
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getHypedTracks()
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $self )
		{
			$params = array(
				'page'  => $page,
				'limit' => $limit,
			);

			$result       = $self->get( Chart::PREFIX . 'getHypedTracks', $params );
			$resultTracks = $result['tracks'];

			if ( ! isset( $resultTracks['track'] ) )
			{
				throw new NotFoundException( 'No hyped tracks found!' );
			}

			$totalResults = (int) $resultTracks['@attr']['total'];
			$totalPages   = (int) $resultTracks['@attr']['totalPages'];

			if ( isset( $resultTracks['track'][0] ) )
			{
				$tracks = $resultTracks['track'];
			}
			else
			{
				$tracks = array( $resultTracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Track = new Data\Chart\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setDuration( (int) $trackRow['duration'] );
				$Track->setPercentageChange( (int) $trackRow['percentagechange'] );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );

				$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );
				$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['fulltrack'] ) );

				$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

				$TrackImages = new ArrayCollection();

				if ( isset( $trackRow['image'] ) )
				{
					foreach ( $trackRow['image'] as $image )
					{
						$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Track->setImages( $TrackImages );

				$List->add( $Track );
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
	 * @link http://www.last.fm/api/show/chart.getLovedTracks
	 *
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getLovedTracks()
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $self )
		{
			$params = array(
				'page'  => $page,
				'limit' => $limit,
			);

			$result       = $self->get( Chart::PREFIX . 'getLovedTracks', $params );
			$resultTracks = $result['tracks'];

			if ( ! isset( $resultTracks['track'] ) )
			{
				throw new NotFoundException( 'No loved tracks found!' );
			}

			$totalResults = (int) $resultTracks['@attr']['total'];
			$totalPages   = (int) $resultTracks['@attr']['totalPages'];

			if ( isset( $resultTracks['track'][0] ) )
			{
				$tracks = $resultTracks['track'];
			}
			else
			{
				$tracks = array( $resultTracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Track = new Data\Chart\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setDuration( (int) $trackRow['duration'] );
				$Track->setLoves( (int) $trackRow['loves'] );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );

				$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );
				$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['fulltrack'] ) );

				$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

				$TrackImages = new ArrayCollection();

				if ( isset( $trackRow['image'] ) )
				{
					foreach ( $trackRow['image'] as $image )
					{
						$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Track->setImages( $TrackImages );

				$List->add( $Track );
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
	 * @link http://www.last.fm/api/show/chart.getTopArtists
	 *
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopArtists()
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $self )
		{
			$params = array(
				'page'  => $page,
				'limit' => $limit,
			);

			$result        = $self->get( Chart::PREFIX . 'getTopArtists', $params );
			$resultArtists = $result['artists'];

			if ( ! isset( $resultArtists['artist'] ) )
			{
				throw new NotFoundException( 'No top artists found!' );
			}

			$totalResults = (int) $resultArtists['@attr']['total'];
			$totalPages   = (int) $resultArtists['@attr']['totalPages'];

			if ( isset( $resultArtists['artist'][0] ) )
			{
				$artists = $resultArtists['artist'];
			}
			else
			{
				$artists = array( $resultArtists['artist'] );
			}

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new Data\Chart\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );
				$Artist->setPlaycount( (int) $artistRow['playcount'] );
				$Artist->setListeners( (int) $artistRow['listeners'] );
				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) ( (int) $artistRow['streamable'] ) );

				$ArtistImages = new ArrayCollection();

				if ( isset( $artistRow['image'] ) )
				{
					foreach ( $artistRow['image'] as $image )
					{
						$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
					}
				}

				$Artist->setImages( $ArtistImages );

				$List->add( $Artist );
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
	 * @link http://www.last.fm/api/show/chart.getTopTags
	 *
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopTags()
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $self )
		{
			$params = array(
				'page'  => $page,
				'limit' => $limit,
			);

			$result     = $self->get( Chart::PREFIX . 'getTopTags', $params );
			$resultTags = $result['tags'];

			if ( ! isset( $resultTags['tag'] ) )
			{
				throw new NotFoundException( 'No top tags found!' );
			}

			$totalResults = (int) $resultTags['@attr']['total'];
			$totalPages   = (int) $resultTags['@attr']['totalPages'];

			if ( isset( $resultTags['tag'][0] ) )
			{
				$tags = $resultTags['tag'];
			}
			else
			{
				$tags = array( $resultTags['tag'] );
			}

			$List = new ArrayCollection();

			foreach ( $tags as $tagRow )
			{
				$Tag = new Data\Chart\Tag();

				$Tag->setName( Util::toSting( $tagRow['name'] ) );
				$Tag->setUrl( Util::toSting( $tagRow['url'] ) );
				$Tag->setReach( (int) $tagRow['reach'] );
				$Tag->setTaggings( (int) $tagRow['taggings'] );
				$Tag->setStreamable( (bool) ( (int) $tagRow['streamable'] ) );

				$Tag->setWikiPublished( Util::toSting( $tagRow['wiki']['published'] ) );
				$Tag->setWikiSummary( Util::toSting( $tagRow['wiki']['summary'] ) );
				$Tag->setWikiContent( Util::toSting( $tagRow['wiki']['content'] ) );

				$List->add( $Tag );
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
	 * @link http://www.last.fm/api/show/chart.getTopTracks
	 *
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopTracks()
	{
		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $self )
		{
			$params = array(
				'page'  => $page,
				'limit' => $limit,
			);

			$result       = $self->get( Chart::PREFIX . 'getTopTracks', $params );
			$resultTracks = $result['tracks'];

			if ( ! isset( $resultTracks['track'] ) )
			{
				throw new NotFoundException( 'No top tracks found!' );
			}

			$totalResults = (int) $resultTracks['@attr']['total'];
			$totalPages   = (int) $resultTracks['@attr']['totalPages'];

			if ( isset( $resultTracks['track'][0] ) )
			{
				$tracks = $resultTracks['track'];
			}
			else
			{
				$tracks = array( $resultTracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $tracks as $trackRow )
			{
				$Track = new Data\Chart\Track();

				$Track->setName( Util::toSting( $trackRow['name'] ) );
				$Track->setDuration( (int) $trackRow['duration'] );
				$Track->setPlaycount( (int) $trackRow['playcount'] );
				$Track->setListeners( (int) $trackRow['listeners'] );
				$Track->setMbId( Util::toSting( $trackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $trackRow['url'] ) );

				$Track->setStreamable( (bool) ( (int) $trackRow['streamable']['#text'] ) );
				$Track->setStreamableFulltrack( (bool) ( (int) $trackRow['streamable']['fulltrack'] ) );

				$Track->setArtistName( Util::toSting( $trackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $trackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $trackRow['artist']['url'] ) );

				$TrackImages = new ArrayCollection();

				foreach ( $trackRow['image'] as $image )
				{
					$TrackImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}

				$Track->setImages( $TrackImages );

				$List->add( $Track );
			}

			return array(
				'results'       => $List,
				'total_pages'   => $totalPages,
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}
}
