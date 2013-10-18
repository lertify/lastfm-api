<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup,

    Lertify\Lastfm\Api\Data\Album\AffiliationsCollection,
    Lertify\Lastfm\Api\Data\Album\Album;

class AlbumTest extends Setup
{
	/**
	 * @return void
	 */
	public function t1estAddTags()
	{
		$status = $this->lastfm->album()->addTags( 'Coldplay', 'Mylo Xyloto', array( 'Awesome', 'Top' ), $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testGetBuylinks()
	{
		$Buylinks = $this->lastfm->album()->getBuylinks( 'Cher', 'Believe', 'Estonia' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\AffiliationsCollection', $Buylinks, 'Buylinks are not an instance of Data\Album\AffiliationsCollection' );

		$this->assertAffiliations( $Buylinks );

		$Buylinks = $this->lastfm->album()->getBuylinksByMbid( '69766f29-b82f-4fcd-b242-27b02786e691', 'Estonia' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\AffiliationsCollection', $Buylinks, 'Buylinks are not an instance of Data\Album\AffiliationsCollection' );

		$this->assertAffiliations( $Buylinks );
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album\AffiliationsCollection $Affiliations
	 */
	protected function assertAffiliations( AffiliationsCollection $Affiliations )
	{
		$PhysicalAffiliations = $Affiliations->getPhysicals();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\PhysicalsCollection', $PhysicalAffiliations, 'PhysicalAffiliations is not an instance of Data\Album\PhysicalsCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $PhysicalAffiliations, 'PhysicalAffiliations is not an instance of Data\ArrayCollection' );

		/** @var $PhysicalAffiliation \Lertify\Lastfm\Api\Data\Album\Affiliation */
		foreach ( $PhysicalAffiliations as $PhysicalAffiliation )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Affiliation', $PhysicalAffiliation, 'PhysicalAffiliation is not an instance of Data\Album\Affiliation' );

			if ( $Price = $PhysicalAffiliation->getPrice() )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Price', $Price, 'Price is not an instance of Data\Album\Price' );
			}
		}

		$DownloadAffiliations = $Affiliations->getDownloads();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\DownloadsCollection', $DownloadAffiliations, 'DownloadAffiliations is not an instance of Data\Album\DownloadsCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $DownloadAffiliations, 'DownloadAffiliations is not an instance of Data\ArrayCollection' );

		/** @var $DownloadAffiliation \Lertify\Lastfm\Api\Data\Album\Affiliation */
		foreach ( $DownloadAffiliations as $DownloadAffiliation )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Affiliation', $DownloadAffiliation, 'DownloadAffiliation is not an instance of Data\Album\Affiliation' );

			if ( $Price = $DownloadAffiliation->getPrice() )
			{
				$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Price', $Price, 'Price is not an instance of Data\Album\Price' );
			}
		}
	}

	/**
	 * @return void
	 */
	public function t1estGetInfo()
	{
		$Album = $this->lastfm->album()->getInfo( 'The Offspring', 'Conspiracy of One' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Album', $Album, 'Album is not an instance of Data\Album\Album' );

		$this->assertAlbum( $Album );

		$Album = $this->lastfm->album()->getInfoByMbid( '86b5434d-9479-35e3-98ca-8fbcfcf4e357' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Album', $Album, 'Album is not an instance of Data\Album\Album' );

		$this->assertAlbum( $Album );
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album\Album $Album
	 */
	protected function assertAlbum( Album $Album )
	{
		$this->assertInstanceOf( 'DateTime', $Album->getReleasedate(), 'Releasedate is not an instance of DateTime' );

		$Images = $Album->getImages();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\ImagesCollection', $Images, 'Images are not an instance of Data\Album\ImagesCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Images, 'Images are not an instance of Data\ArrayCollection' );

		foreach ( $Images as $Image )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Images', $Image, 'Image is not an instance of Data\Album\Images' );
		}

		$Tracks = $Album->getTracks();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\TracksCollection', $Tracks, 'Tracks are not an instance of Data\Album\ImagesCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tracks, 'Tracks are not an instance of Data\ArrayCollection' );

		/** @var $Track \Lertify\Lastfm\Api\Data\Album\Tracks */
		foreach ( $Tracks as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Tracks', $Track, 'Track is not an instance of Data\Album\Tracks' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Streamable', $Track->getStreamable(), 'Streamable is not an instance of Data\Album\Streamable' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Artist', $Track->getArtist(), 'Artist is not an instance of Data\Album\Artist' );
		}

		$Toptags = $Album->getToptags();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\ToptagsCollection', $Toptags, 'Toptags are not an instance of Data\Album\ToptagsCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Toptags, 'Toptags are not an instance of Data\ArrayCollection' );

		foreach ( $Toptags as $Toptag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Tags', $Toptag, 'Toptag is not an instance of Data\Album\Toptags' );
		}
	}

	/**
	 * @return void
	 */
	public function t1estGetShouts()
	{
		$PagedCollection = $this->lastfm->album()->getShouts( 'The Offspring', 'Conspiracy of One' );

		$this->assertInternalType( 'int', $PagedCollection->count(), 'Is not an integer value' );
		$this->assertInternalType( 'int', $PagedCollection->countPages(), 'Is not an integer value' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $PagedCollection->getPage( 1 ), 'Page result is not an instance of ArrayCollection' );
		$this->assertFalse( $PagedCollection->isEmpty(), 'Current result should not be empty' );
		$this->assertGreaterThanOrEqual( 102, $PagedCollection->count() );

		$PagedCollection = $this->lastfm->album()->getShoutsByMbid( '0405cb4c-fc88-3338-b5d6-1fa71a9562e4' );

		$this->assertInternalType( 'int', $PagedCollection->count(), 'Is not an integer value' );
		$this->assertInternalType( 'int', $PagedCollection->countPages(), 'Is not an integer value' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $PagedCollection->getPage( 1 ), 'Page result is not an instance of ArrayCollection' );
		$this->assertFalse( $PagedCollection->isEmpty(), 'Current result should not be empty' );
		$this->assertGreaterThanOrEqual( 673, $PagedCollection->count() );
	}

	/**
	 * @return void
	 */
	public function t1estGetTags()
	{
		$Tags = $this->lastfm->album()->getTags( 'The Offspring', 'Conspiracy of One', $GLOBALS['tests_username'] );

		$this->assertNotEmpty( $Tags, 'Can not be empty' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags is not an instance of ArrayCollection' );

		$Tags = $this->lastfm->album()->getTagsAuth( 'The Offspring', 'Conspiracy of One', $GLOBALS['auth_session_key'] );

		$this->assertNotEmpty( $Tags, 'Can not be empty' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags is not an instance of ArrayCollection' );

		$Tags = $this->lastfm->album()->getTagsByMbid( '0405cb4c-fc88-3338-b5d6-1fa71a9562e4', $GLOBALS['tests_username'] );

		$this->assertEquals( 0, $Tags->count(), 'Must be empty' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags is not an instance of ArrayCollection' );

		$Tags = $this->lastfm->album()->getTagsByMbidAuth( '0405cb4c-fc88-3338-b5d6-1fa71a9562e4', $GLOBALS['auth_session_key'] );

		$this->assertEquals( 0, $Tags->count(), 'Must be empty' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tags, 'Tags is not an instance of ArrayCollection' );
	}

	/**
	 * @return void
	 */
	public function t1estGetTopTag()
	{
		$TopTags = $this->lastfm->album()->getTopTags( 'Radiohead', 'The Bends' );

		$this->assertGreaterThan( 1, $TopTags->count() );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTags, 'TopTags is not an instance of ArrayCollection' );

		$TopTags = $this->lastfm->album()->getTopTagsByMbid( '0405cb4c-fc88-3338-b5d6-1fa71a9562e4' );

		$this->assertGreaterThan( 1, $TopTags->count() );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TopTags, 'TopTags is not an instance of ArrayCollection' );
	}

	/**
	 * @return void
	 */
	public function t1estRemoveTag()
	{
		$status = $this->lastfm->album()->removeTag( 'Coldplay', 'Mylo Xyloto', 'great', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );

		$status = $this->lastfm->album()->removeTag( 'Coldplay', 'Mylo Xyloto', 'Awesome', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function t1estSearch()
	{
		$PagedCollection = $this->lastfm->album()->search( 'Conspiracy of One' );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $PagedCollection );
		$this->assertEquals( 'object', gettype( $PagedCollection ) );
		$this->assertEquals( 1, $PagedCollection->count() );

		/** @var $Album \Lertify\Lastfm\Api\Data\Album\Album */
		foreach ( $PagedCollection->getPage( 1 ) as $Album )
		{
			$this->assertEquals( 'The Offspring', $Album->getArtist() );
			$this->assertEquals( 'Conspiracy of One', $Album->getName() );
		}

		$PagedCollection = $this->lastfm->album()->search( 'believe' );
		$PagedCollection->setLimit( 10 );

		$this->assertEquals( 10, $PagedCollection->getPage( 1 )->count() );
	}

	/**
	 * @return void
	 */
	public function t1estShare()
	{
		$status = $this->lastfm->album()->share( 'Coldplay', 'Mylo Xyloto', $GLOBALS['tests_email'], $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}
}
