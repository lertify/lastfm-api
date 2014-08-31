<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup,

	Lertify\Lastfm\Api\Data\PagedCollection,
    Lertify\Lastfm\Api\Data\Album\AffiliationsCollection,
	Lertify\Lastfm\Api\Data\Album\Affiliation,
	Lertify\Lastfm\Api\Data\Album\TagsCollection,
    Lertify\Lastfm\Api\Data\Album\Album,
	Lertify\Lastfm\Api\Data\Album\Wiki;

class AlbumTest extends Setup
{
	/**
	 * @return void
	 */
	public function testAddTags()
	{
		$PostResponse = $this->lastfm->album()->addTags( 'Coldplay', 'Mylo Xyloto', array( 'Awesome', 'Top' ), $GLOBALS['auth_session_key'] );

		$this->assertEquals( 'ok', $PostResponse->getStatus() );
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

		/** @var \Lertify\Lastfm\Api\Data\Album\Affiliation $PhysicalAffiliation */
		foreach ( $PhysicalAffiliations as $PhysicalAffiliation )
		{
			$this->assertAffiliation( $PhysicalAffiliation );
		}

		$DownloadAffiliations = $Affiliations->getDownloads();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\DownloadsCollection', $DownloadAffiliations, 'DownloadAffiliations is not an instance of Data\Album\DownloadsCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $DownloadAffiliations, 'DownloadAffiliations is not an instance of Data\ArrayCollection' );

		/** @var \Lertify\Lastfm\Api\Data\Album\Affiliation $DownloadAffiliation */
		foreach ( $DownloadAffiliations as $DownloadAffiliation )
		{
			$this->assertAffiliation( $DownloadAffiliation );
		}
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album\Affiliation $Affiliation
	 */
	private function assertAffiliation( Affiliation $Affiliation )
	{
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Affiliation', $Affiliation, 'Affiliation is not an instance of Data\Album\Affiliation' );

		if ( $Price = $Affiliation->getPrice() )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Price', $Price, 'Price is not an instance of Data\Album\Price' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetInfo()
	{
		$Album = $this->lastfm->album()->getInfo( 'The Offspring', 'Conspiracy of One' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Album', $Album, 'Album is not an instance of Data\Album\Album' );

		$this->assertAlbum( $Album );

		$Album = $this->lastfm->album()->getInfoByMbid( 'a57b3932-e915-4d58-ad9a-61d88dcc1baa' );
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
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Image', $Image, 'Image is not an instance of Data\Album\Image' );
		}

		$Tracks = $Album->getTracks();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\TracksCollection', $Tracks, 'Tracks are not an instance of Data\Album\ImagesCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Tracks, 'Tracks are not an instance of Data\ArrayCollection' );

		/** @var \Lertify\Lastfm\Api\Data\Album\Track $Track */
		foreach ( $Tracks as $Track )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Track', $Track, 'Track is not an instance of Data\Album\Track' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Streamable', $Track->getStreamable(), 'Streamable is not an instance of Data\Album\Streamable' );
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Artist', $Track->getArtist(), 'Artist is not an instance of Data\Album\Artist' );
		}

		$this->assertTags( $Album->getToptags() );
		$this->assertWiki( $Album->getWiki() );
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album\Wiki $Wiki
	 */
	protected function assertWiki( Wiki $Wiki = null )
	{
		if ( null === $Wiki )
		{
			return;
		}

		$this->assertInstanceOf( 'DateTime', $Wiki->getPublished(), 'Published is not an instance of DateTime' );
	}

	/**
	 * @return void
	 */
	public function testGetShouts()
	{
		$PagedCollection = $this->lastfm->album()->getShouts( 'The Offspring', 'Conspiracy of One' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $PagedCollection, 'PagedCollection is not an instance of Data\PagedCollection' );
		$this->assertGreaterThanOrEqual( 102, $PagedCollection->count() );

		$this->assertShoutsCollection( $PagedCollection );

		$PagedCollection = $this->lastfm->album()->getShoutsByMbid( '86b5434d-9479-35e3-98ca-8fbcfcf4e357' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\PagedCollection', $PagedCollection, 'PagedCollection is not an instance of Data\PagedCollection' );
		$this->assertGreaterThanOrEqual( 42, $PagedCollection->count() );

		$this->assertShoutsCollection( $PagedCollection );
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\PagedCollection $PagedCollection
	 */
	protected function assertShoutsCollection( PagedCollection $PagedCollection )
	{
		$this->assertInternalType( 'int', $PagedCollection->count(), 'Is not an integer value' );
		$this->assertInternalType( 'int', $PagedCollection->countPages(), 'Is not an integer value' );
		$this->assertFalse( $PagedCollection->isEmpty(), 'Current result should not be empty' );

		$ShoutsCollection = $PagedCollection->getPage( 1 );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\ShoutsCollection', $ShoutsCollection, 'ShoutsCollection is not an instance of Data\Album\ShoutsCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ShoutsCollection, 'ShoutsCollection is not an instance of Data\ArrayCollection' );

		/** @var $Shout \Lertify\Lastfm\Api\Data\Album\Shout */
		foreach ( $ShoutsCollection as $Shout )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Shout', $Shout, 'Shout is not an instance of Data\Album\Shout' );
			$this->assertInstanceOf( 'DateTime', $Shout->getDate(), 'Shout date is not an instance of DateTime' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTags()
	{
		$Tags = $this->lastfm->album()->getTags( 'The Offspring', 'Conspiracy of One', $GLOBALS['tests_username'] );
		$this->assertNotEmpty( $Tags, 'Can not be empty' );
		$this->assertTags( $Tags );

		$Tags = $this->lastfm->album()->getTagsAuth( 'The Offspring', 'Conspiracy of One', $GLOBALS['auth_session_key'] );
		$this->assertNotEmpty( $Tags, 'Can not be empty' );
		$this->assertTags( $Tags );

		$Tags = $this->lastfm->album()->getTagsByMbid( '86b5434d-9479-35e3-98ca-8fbcfcf4e357', $GLOBALS['tests_username'] );
		$this->assertEquals( 0, $Tags->count(), 'Must be empty' );
		$this->assertTags( $Tags );

		$Tags = $this->lastfm->album()->getTagsByMbidAuth( '86b5434d-9479-35e3-98ca-8fbcfcf4e357', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 0, $Tags->count(), 'Must be empty' );
		$this->assertTags( $Tags );
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Album\TagsCollection $TagsCollection
	 */
	public function assertTags( TagsCollection $TagsCollection )
	{
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\TagsCollection', $TagsCollection, 'TagsCollection are not an instance of Data\Album\TagsCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $TagsCollection, 'TagsCollection are not an instance of Data\ArrayCollection' );

		foreach ( $TagsCollection as $Tag )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Tag', $Tag, 'Tag is not an instance of Data\Album\Tag' );
		}
	}

	/**
	 * @return void
	 */
	public function testGetTopTag()
	{
		$TopTags = $this->lastfm->album()->getTopTags( 'Radiohead', 'The Bends' );
		$this->assertGreaterThan( 1, $TopTags->count() );
		$this->assertTags( $TopTags );

		$TopTags = $this->lastfm->album()->getTopTagsByMbid( '86b5434d-9479-35e3-98ca-8fbcfcf4e357' );
		$this->assertGreaterThan( 1, $TopTags->count() );
		$this->assertTags( $TopTags );
	}

	/**
	 * @return void
	 */
	public function testRemoveTag()
	{
		$PostResponse = $this->lastfm->album()->removeTag( 'Coldplay', 'Mylo Xyloto', 'great', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $PostResponse->getStatus() );

		$PostResponse = $this->lastfm->album()->removeTag( 'Coldplay', 'Mylo Xyloto', 'Awesome', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $PostResponse->getStatus() );
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