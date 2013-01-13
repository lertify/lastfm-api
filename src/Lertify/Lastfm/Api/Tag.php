<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Util\Util,
	Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Api\Data\PagedCollection;

class Tag extends AbstractApi
{
	const
		PREFIX = 'tag.';

	/**
	 * @link http://www.last.fm/api/show/tag.getInfo
	 *
	 * @param string $tag
	 * @return \Lertify\Lastfm\Api\Data\Tag\Tag
	 */
	public function getInfo( $tag )
	{
		$params = array(
			'tag' => $tag,
		);

		$result    = $this->get( self::PREFIX . 'getInfo', $params );
		$resultTag = $result['tag'];

		$Tag = new Data\Tag\Tag();

		$Tag->setName( Util::toSting( $resultTag['name'] ) );
		$Tag->setUrl( Util::toSting( $resultTag['url'] ) );
		$Tag->setReach( (int) $resultTag['reach'] );
		$Tag->setTaggings( (int) $resultTag['taggings'] );
		$Tag->setStreamable( (bool) $resultTag['streamable'] );

		if ( ! empty( $resultTag['wiki'] ) )
		{
			$Tag->setWikiPublished( Util::toSting( $resultTag['wiki']['published'] ) );
			$Tag->setWikiSummary( Util::toSting( $resultTag['wiki']['summary'] ) );
			$Tag->setWikiContent( Util::toSting( $resultTag['wiki']['content'] ) );
		}

		return $Tag;
	}

	/**
	 * @link http://www.last.fm/api/show/tag.getSimilar
	 *
	 * @param string $tag
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getSimilar( $tag )
	{
		$params = array(
			'tag' => $tag,
		);

		$result            = $this->get( self::PREFIX . 'getSimilar', $params );
		$resultSimilartags = $result['similartags'];

		$Tags = new ArrayCollection();

		foreach ( $resultSimilartags['tag'] as $tagRow )
		{
			$Tag = new Data\Tag\Tag();

			$Tag->setName( Util::toSting( $tagRow['name'] ) );
			$Tag->setUrl( Util::toSting( $tagRow['url'] ) );
			$Tag->setStreamable( (bool) $tagRow['streamable'] );

			$Tags->add( $Tag );
		}

		return $Tags;
	}

	/**
	 * @link http://www.last.fm/api/show/tag.getTopAlbums
	 *
	 * @param string $tag
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopAlbums( $tag )
	{
		$params = array(
			'tag' => $tag,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params          = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result          = $self->get( Tag::PREFIX . 'getTopAlbums', $params );
			$resultTopalbums = $result['topalbums'];

			if ( ! isset( $resultTopalbums['album'] ) )
			{
				throw new NotFoundException( 'This tag isn\'t linked to any albums!' );
			}

			$totalResults = (int) $resultTopalbums['@attr']['total'];
			$totalPages   = (int) $resultTopalbums['@attr']['totalPages'];

			if ( isset( $resultTopalbums['album'][0] ) )
			{
				$albums = $resultTopalbums['album'];
			}
			else
			{
				$albums = array( $resultTopalbums['album'] );
			}

			$List = new ArrayCollection();

			foreach ( $albums as $albumRow )
			{
				$Album = new Data\Tag\Album();

				$Album->setName( Util::toSting( $albumRow['name'] ) );
				$Album->setMbid( Util::toSting( $albumRow['mbid'] ) );
				$Album->setUrl( Util::toSting( $albumRow['url'] ) );

				$Artist = new Data\Tag\Artist();

				$Artist->setName( Util::toSting( $albumRow['artist']['name'] ) );
				$Artist->setMbid( Util::toSting( $albumRow['artist']['mbid'] ) );
				$Artist->setUrl( Util::toSting( $albumRow['artist']['url'] ) );

				$Album->setArtist( $Artist );

				$AlbumImages = new ArrayCollection();

				foreach ( $albumRow['image'] as $image )
				{
					$AlbumImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}

				$Album->setImages( $AlbumImages );
				$Artist->setRank( (int) $albumRow['@attr']['rank'] );

				$List->add( $Album );
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
	 * @link http://www.last.fm/api/show/tag.getTopArtists
	 *
	 * @param string $tag
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopArtists( $tag )
	{
		$params = array(
			'tag' => $tag,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params           = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result           = $self->get( Tag::PREFIX . 'getTopArtists', $params );
			$resultTopartists = $result['topartists'];

			if ( ! isset( $resultTopartists['artist'] ) )
			{
				throw new NotFoundException( 'This tag isn\'t linked to any artists!' );
			}

			if ( isset( $resultTopartists['artist'][0] ) )
			{
				$artists = $resultTopartists['artist'];
			}
			else
			{
				$artists = array( $resultTopartists['artist'] );
			}

			$totalPages   = 0;
			$totalResults = 0;

			// @todo Fix, until information regarding amount is passed also
			if ( $artists && 50 == count( $artists ) )
			{
				$totalPages   = $page + 1;
				$totalResults = $page * 50;
			}

			$List = new ArrayCollection();

			foreach ( $artists as $artistRow )
			{
				$Artist = new Data\Tag\Artist();

				$Artist->setName( Util::toSting( $artistRow['name'] ) );
				$Artist->setMbid( Util::toSting( $artistRow['mbid'] ) );
				$Artist->setUrl( Util::toSting( $artistRow['url'] ) );
				$Artist->setStreamable( (bool) $artistRow['streamable'] );
				$Artist->setRank( (int) $artistRow['@attr']['rank'] );

				$ArtistImages = new ArrayCollection();

				foreach ( $artistRow['image'] as $image )
				{
					$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
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
	 * @link http://www.last.fm/api/show/tag.getTopTags
	 *
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getTopTags()
	{
		$params = array();

		$result        = $this->get( self::PREFIX . 'getTopTags', $params );
		$resultToptags = $result['toptags'];

		if ( ! isset( $resultToptags['tag'] ) )
		{
			throw new NotFoundException( 'No top tags!' );
		}

		if ( isset( $resultToptags['tag'][0] ) )
		{
			$topTags = $resultToptags['tag'];
		}
		else
		{
			$topTags = array( $resultToptags['tag'] );
		}

		$List = new ArrayCollection();

		foreach ( $topTags as $topTagRow )
		{
			$Tag = new Data\Tag\Tag();

			$Tag->setName( Util::toSting( $topTagRow['name'] ) );
			$Tag->setCount( (int) $topTagRow['count'] );
			$Tag->setUrl( Util::toSting( $topTagRow['url'] ) );

			$List->add( $Tag );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/tag.getTopTracks
	 *
	 * @param string $tag
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function getTopTracks( $tag )
	{
		$params = array(
			'tag' => $tag,
		);

		$self           = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params          = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result          = $self->get( Tag::PREFIX . 'getTopTracks', $params );
			$resultToptracks = $result['toptracks'];

			if ( ! isset( $resultToptracks['track'] ) )
			{
				throw new NotFoundException( 'This tag isn\'t linked to any top track!' );
			}

			$totalResults = (int) $resultToptracks['@attr']['total'];
			$totalPages   = (int) $resultToptracks['@attr']['totalPages'];

			if ( isset( $resultToptracks['track'][0] ) )
			{
				$topTracks = $resultToptracks['track'];
			}
			else
			{
				$topTracks = array( $resultToptracks['track'] );
			}

			$List = new ArrayCollection();

			foreach ( $topTracks as $topTrackRow )
			{
				$Track = new Data\Tag\Track();

				$Track->setName( Util::toSting( $topTrackRow['name'] ) );
				$Track->setDuration( (int) $topTrackRow['duration'] );
				$Track->setMbId( Util::toSting( $topTrackRow['mbid'] ) );
				$Track->setUrl( Util::toSting( $topTrackRow['url'] ) );
				$Track->setRank( (int) $topTrackRow['@attr']['rank'] );

				$Track->setStreamable( (bool) $topTrackRow['streamable']['#text'] );
				$Track->setStreamableFulltrack( (bool) $topTrackRow['streamable']['fulltrack'] );

				$Track->setArtistName( Util::toSting( $topTrackRow['artist']['name'] ) );
				$Track->setArtistMbId( Util::toSting( $topTrackRow['artist']['mbid'] ) );
				$Track->setArtistUrl( Util::toSting( $topTrackRow['artist']['url'] ) );

				$TrackImages = new ArrayCollection();

				if ( isset( $topTrackRow['image'] ) )
				{
					foreach ( $topTrackRow['image'] as $image )
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
	 * @link http://www.last.fm/api/show/tag.getWeeklyChartList
	 *
	 * @param string $tag
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getWeeklyChartList( $tag )
	{
		$params = array(
			'tag' => $tag,
		);

		$result                = $this->get( self::PREFIX . 'getWeeklyChartList', $params );
		$resultWeeklychartlist = $result['weeklychartlist'];

		$List = new ArrayCollection();

		foreach ( $resultWeeklychartlist['chart'] as $chartRow )
		{
			$Chart = new Data\Tag\Chart();

			$Chart->setFrom( (int) $chartRow['from'] );
			$Chart->setTo( (int) $chartRow['to'] );

			$List->add( $Chart );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/tag.getWeeklyArtistChart
	 *
	 * @param string $tag
	 * @param int $limit
	 * @param int|null $from
	 * @param int|null $to
	 * @return \Lertify\Lastfm\Api\Data\ArrayCollection
	 */
	public function getWeeklyArtistChart( $tag, $limit = 50, $from = null, $to = null )
	{
		$params = array(
			'tag'   => $tag,
			'limit' => $limit,
			'from'  => $from,
			'to'    => $to,
		);

		$result                  = $this->get( self::PREFIX . 'getWeeklyArtistChart', $params );
		$resultWeeklyartistchart = $result['weeklyartistchart'];

		if ( isset( $resultWeeklyartistchart['artist'][0] ) )
		{
			$artistChart = $resultWeeklyartistchart['artist'];
		}
		else
		{
			$artistChart = array( $resultWeeklyartistchart['artist'] );
		}

		$List = new ArrayCollection();

		foreach ( $artistChart as $artistChartRow )
		{
			$Artist = new Data\Tag\Artist();

			$Artist->setName( Util::toSting( $artistChartRow['name'] ) );
			$Artist->setWeight( (int) $artistChartRow['weight'] );
			$Artist->setMbid( Util::toSting( $artistChartRow['mbid'] ) );
			$Artist->setUrl( Util::toSting( $artistChartRow['url'] ) );
			$Artist->setStreamable( (bool) $artistChartRow['streamable'] );

			$ArtistImages = new ArrayCollection();

			foreach ( $artistChartRow['image'] as $image )
			{
				$ArtistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
			}

			$Artist->setImages( $ArtistImages );

			$List->add( $Artist );
		}

		return $List;
	}

	/**
	 * @link http://www.last.fm/api/show/tag.search
	 *
	 * @param string $tag
	 * @throws \Lertify\Lastfm\Exception\NotFoundException
	 * @return \Lertify\Lastfm\Api\Data\PagedCollection
	 */
	public function search( $tag )
	{
		$params = array(
			'tag' => $tag,
		);

		$self = $this;
		$resultCallback = function( $page, $limit ) use ( $params, $self )
		{
			$params           = array_merge( $params, array( 'page' => $page, 'limit' => $limit ) );
			$result           = $self->get( Tag::PREFIX . 'search', $params );
			$resultTagmatches = $result['results']['tagmatches'];

			if ( ! isset( $resultTagmatches['tag'] ) )
			{
				throw new NotFoundException( 'There is no such tag!' );
			}

			if ( isset( $resultTagmatches['tag'][0] ) )
			{
				$tags = $resultTagmatches['tag'];
			}
			else
			{
				$tags = array( $resultTagmatches['tag'] );
			}

			$totalResults = (int) $result['results']['opensearch:totalResults'];
			$itemsPerPage = (int) $result['results']['opensearch:itemsPerPage'];

			$List = new ArrayCollection();

			foreach ( $tags as $tagsRow )
			{
				$Tag = new Data\Tag\Tag();

				$Tag->setName( Util::toSting( $tagsRow['name'] ) );
				$Tag->setCount( (int) $tagsRow['count'] );
				$Tag->setUrl( Util::toSting( $tagsRow['url'] ) );

				$List->add( $Tag );
			}

			return array(
				'results'       => $List,
				'total_pages'   => ceil( $totalResults / $itemsPerPage ),
				'total_results' => $totalResults,
			);
		};

		return new PagedCollection( $resultCallback );
	}
}
