<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class TrackTest extends Setup
{
	/**
	 * @return void
	 */
	public function testAddTags()
	{
		$status = $this->lastfm->track()->addTags( 'Coldplay', 'Paradise', array( 'Awesome', 'Top' ), $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testBan()
	{
		$status = $this->lastfm->track()->ban( 'Coldplay', 'Paradise', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testGetBuylinks()
	{
		$Buylinks = $this->lastfm->track()->getBuylinks( 'Coldplay', 'Paradise' );

		$this->assertFalse( $Buylinks->isEmpty(), 'Is empty when it should not be' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Buylinks->get( 'physicals' ), 'Affiliations are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Buylinks->get( 'downloads' ), 'Affiliations are not an instance of ArrayCollection' );

		$Buylinks = $this->lastfm->track()->getBuylinksByMbid( '690d4cf0-21af-48ad-82d5-f1f47076e01b' );

		$this->assertFalse( $Buylinks->isEmpty(), 'Is empty when it should not be' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Buylinks->get( 'physicals' ), 'Affiliations are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Buylinks->get( 'downloads' ), 'Affiliations are not an instance of ArrayCollection' );
	}

	/**
	 * @return void
	 */
	public function testGetCorrection()
	{
		$Track = $this->lastfm->track()->getCorrection( 'Coldpla', 'Paradise' );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Track', $Track, 'Track is not an instance of Lertify\Lastfm\Api\Data\Track\Track' );
	}

	/**
	 * @return void
	 */
	public function testGetFingerprintMetadata()
	{
		$TracksCollection = $this->lastfm->track()->getFingerprintMetadata( 1234567 );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TracksCollection, 'TracksCollection is not an instance of ArrayCollection' );

		foreach ( $TracksCollection as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Track', $Track, 'Track is not an instance of Lertify\Lastfm\Api\Data\Track\Track' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetInfo()
	{
		$Track = $this->lastfm->track()->getInfo( 'Coldplay', 'Paradise' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Track', $Track, 'Track is not an instance of Lertify\Lastfm\Api\Data\Track\Track' );

		$Album = $Track->getAlbum();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Album', $Album, 'Album is not an instance of Lertify\Lastfm\Api\Data\Track\Album' );

		$AlbumImages = $Album->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $AlbumImages, 'AlbumImages is not an instance of ArrayCollection' );

		$TopTags = $Track->getTopTags();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTags, 'TopTags is not an instance of ArrayCollection' );

		if ( ! $TopTags->isEmpty() )
		{
			foreach ( $Track->getTopTags() as $Tag )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Tag', $Tag, 'Tag is not an instance of Lertify\Lastfm\Api\Data\Track\Tag' );
			}
		}

		$Track = $this->lastfm->track()->getInfoByMbid( '690d4cf0-21af-48ad-82d5-f1f47076e01b' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Track', $Track, 'Track is not an instance of Lertify\Lastfm\Api\Data\Track\Track' );

		$Album = $Track->getAlbum();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Album', $Album, 'Album is not an instance of Lertify\Lastfm\Api\Data\Track\Album' );

		$AlbumImages = $Album->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $AlbumImages, 'AlbumImages is not an instance of ArrayCollection' );

		$TopTags = $Track->getTopTags();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTags, 'TopTags is not an instance of ArrayCollection' );

		if ( ! $TopTags->isEmpty() )
		{
			foreach ( $Track->getTopTags() as $Tag )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Tag', $Tag, 'Tag is not an instance of Lertify\Lastfm\Api\Data\Track\Tag' );
			}
		}
	}

	/**
	 * @return void
	 */
	public function testGetShouts()
	{
		$Shouts = $this->lastfm->track()->getShouts( 'Coldplay', 'Paradise' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Shouts, 'Shouts are not an instance of Data\PagedCollection!' );

		/** @var $Shout \Lertify\Lastfm\Api\Data\Track\Shout */
		foreach ( $Shouts->getPage( 1 ) as $Shout )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Shout', $Shout, 'Shout is not an instance of Data\Track\Shout!' );
		}

		$Shouts = $this->lastfm->track()->getShoutsByMbid( '690d4cf0-21af-48ad-82d5-f1f47076e01b' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Shouts, 'Shouts are not an instance of Data\PagedCollection!' );

		/** @var $Shout \Lertify\Lastfm\Api\Data\Track\Shout */
		foreach ( $Shouts->getPage( 1 ) as $Shout )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Shout', $Shout, 'Shout is not an instance of Data\Track\Shout!' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetSimilar()
	{
		$Tracks = $this->lastfm->track()->getSimilar( 'Coldplay', 'Paradise' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tracks, 'Tracks is not an instance of ArrayCollection' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Track\Track */
		foreach ( $Tracks as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Track', $Track, 'Track is not an instance of Lertify\Lastfm\Api\Data\Track\Track' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages is not an instance of ArrayCollection' );
		}

		$Tracks = $this->lastfm->track()->getSimilarByMbid( '690d4cf0-21af-48ad-82d5-f1f47076e01b' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tracks, 'Tracks is not an instance of ArrayCollection' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Track\Track */
		foreach ( $Tracks as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Track', $Track, 'Track is not an instance of Lertify\Lastfm\Api\Data\Track\Track' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages is not an instance of ArrayCollection' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTags()
	{
		$Tags = $this->lastfm->track()->getTags( 'Coldplay', 'Paradise', $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags is not an instance of ArrayCollection' );

		foreach ( $Tags as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Tag', $Tag, 'Tag is not an instance of Lertify\Lastfm\Api\Data\Track\Tag' );
		}

		$Tags = $this->lastfm->track()->getTagsByMbid( '690d4cf0-21af-48ad-82d5-f1f47076e01b', $GLOBALS['tests_username'] );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags is not an instance of ArrayCollection' );

		foreach ( $Tags as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Tag', $Tag, 'Tag is not an instance of Lertify\Lastfm\Api\Data\Track\Tag' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTopFans()
	{
		$Topfans = $this->lastfm->track()->getTopFans( 'Coldplay', 'Paradise' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Topfans, 'Topfans is not an instance of ArrayCollection' );

		/** @var $Topfan \Lertify\Lastfm\Api\Data\Track\User */
		foreach ( $Topfans as $Topfan )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\User', $Topfan, 'Topfan is not an instance of Lertify\Lastfm\Api\Data\Track\User' );

			$TopfanImages = $Topfan->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopfanImages, 'TopfanImages is not an instance of ArrayCollection' );
		}

		$Topfans = $this->lastfm->track()->getTopFansByMbid( '690d4cf0-21af-48ad-82d5-f1f47076e01b' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Topfans, 'Topfans is not an instance of ArrayCollection' );

		/** @var $Topfan \Lertify\Lastfm\Api\Data\Track\User */
		foreach ( $Topfans as $Topfan )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\User', $Topfan, 'Topfan is not an instance of Lertify\Lastfm\Api\Data\Track\User' );

			$TopfanImages = $Topfan->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopfanImages, 'TopfanImages is not an instance of ArrayCollection' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTopTags()
	{
		$Toptags = $this->lastfm->track()->getTopTags( 'Coldplay', 'Paradise' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Toptags, 'Toptags is not an instance of ArrayCollection' );

		foreach ( $Toptags as $Toptag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Tag', $Toptag, 'Toptag is not an instance of Lertify\Lastfm\Api\Data\Track\Tag' );
		}

		$Toptags = $this->lastfm->track()->getTopTagsByMbid( '690d4cf0-21af-48ad-82d5-f1f47076e01b' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Toptags, 'Toptags is not an instance of ArrayCollection' );

		foreach ( $Toptags as $Toptag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Tag', $Toptag, 'Toptag is not an instance of Lertify\Lastfm\Api\Data\Track\Tag' );
		}
	}

	/**
	 * @return void
	 */
	public function testLove()
	{
		$status = $this->lastfm->track()->love( 'Coldplay', 'Paradise', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testRemoveTag()
	{
		$status = $this->lastfm->track()->removeTag( 'Coldplay', 'Paradise', 'Top', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testScrobble()
	{
		$this->lastfm->track()->scrobble( array(), $GLOBALS['auth_session_key'] );
	}

	/**
	 * @return void
	 */
	public function testSearch()
	{
		$Tracks = $this->lastfm->track()->search( 'Coldplay', 'Paradise' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $Tracks, 'Tracks are not an instance of Data\PagedCollection!' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Track\Track */
		foreach ( $Tracks->getPage( 1 ) as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Track\Track', $Track, 'Track is not an instance of Data\Track\Track!' );

			$TrackImages = $Track->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TrackImages, 'TrackImages is not an instance of ArrayCollection' );
		}
	}

	/**
	 * @return void
	 */
	public function testShare()
	{
		$status = $this->lastfm->track()->share( 'Coldplay', 'Paradise', $GLOBALS['tests_email'], $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testUnban()
	{
		$status = $this->lastfm->track()->unban( 'Coldplay', 'Paradise', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testUnlove()
	{
		$status = $this->lastfm->track()->unlove( 'Coldplay', 'Paradise', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testUpdateNowPlaying()
	{
		$this->lastfm->track()->updateNowPlaying( 'Coldplay', 'Paradise', $GLOBALS['auth_session_key'] );
	}
}