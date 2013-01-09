<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Util\Util,
	Lertify\Lastfm\Api\Data\ArrayCollection;

class Playlist extends AbstractApi
{
	const
		PREFIX = 'playlist.';

	/**
	 * @link http://www.last.fm/api/show/playlist.addTrack
	 *
	 * @param int $playlistId
	 * @param string $track
	 * @param string $artist
	 * @param string $sk
	 * @return string
	 */
	public function addTrack( $playlistId, $track, $artist, $sk )
	{
		$params = array(
			'playlistID' => $playlistId,
			'track'      => $track,
			'artist'     => $artist,
			'sk'         => $sk,
		);

		$result = $this->post( self::PREFIX . 'addTrack', $params, array( 'is_signed' => true ) );

		return $result['status'];
	}

	/**
	 * @link http://www.last.fm/api/show/playlist.create
	 *
	 * @param string $sk
	 * @param string|null $title
	 * @param string|null $description
	 * @throws \Exception
	 * @return Data\Playlist\Playlist
	 */
	public function create( $sk, $title = null, $description = null )
	{
		$params = array(
			'sk' => $sk,
		);

		if ( null !== $title )
		{
			$params['title'] = $title;
		}

		if ( null !== $description )
		{
			$params['description'] = $description;
		}

		$result          = $this->post( self::PREFIX . 'create', $params, array( 'is_signed' => true ) );
		$resultPlaylists = $result['playlists'];
		$Playlist        = new Data\Playlist\Playlist();

		if ( ! isset( $resultPlaylists['playlist'] ) )
		{
			throw new \Exception( 'No playlist created!' );
		}

		$playlistRow = $resultPlaylists['playlist'];

		$User = new Data\Playlist\User();
		$User->setName( $resultPlaylists['@attr']['user'] );

		$Playlist->setId( (int) $playlistRow['id'] );
		$Playlist->setTitle( Util::toSting( $playlistRow['title'] ) );
		$Playlist->setDescription( Util::toSting( $playlistRow['description'] ) );
		$Playlist->setDate( Util::toSting( $playlistRow['date'] ) );
		$Playlist->setSize( (int) $playlistRow['size'] );
		$Playlist->setDuration( (int) $playlistRow['duration'] );
		$Playlist->setStreamable( (bool) ( (int) $playlistRow['streamable'] ) );
		$Playlist->setCreator( Util::toSting( $playlistRow['creator'] ) );
		$Playlist->setUrl( Util::toSting( $playlistRow['url'] ) );

		$PlaylistImages = new ArrayCollection();

		if ( isset( $playlistRow['image'] ) )
		{
			foreach ( $playlistRow['image'] as $image )
			{
				$PlaylistImages->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
			}
		}

		$Playlist->setImages( $PlaylistImages );
		$Playlist->setUser( $User );

		return $Playlist;
	}
}
