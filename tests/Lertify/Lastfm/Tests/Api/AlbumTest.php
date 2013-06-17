<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class AlbumTest extends Setup
{
	/**
	 * @return void
	 */
	public function testAddTags()
	{
		$status = $this->lastfm->album()->addTags( 'Coldplay', 'Mylo Xyloto', array( 'Awesome', 'Top' ), $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testGetBuylinks()
	{
		$Buylinks = $this->lastfm->album()->getBuylinks( 'The Offspring', 'Conspiracy of One', 'Estonia' );

		$this->assertFalse( $Buylinks->isEmpty(), 'Is empty when it should not be' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Buylinks->get( 'physicals' ), 'Affiliations are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Buylinks->get( 'downloads' ), 'Affiliations are not an instance of ArrayCollection' );

		$Buylinks = $this->lastfm->album()->getBuylinksByMbid( '0405cb4c-fc88-3338-b5d6-1fa71a9562e4', 'Estonia' );

		$this->assertFalse( $Buylinks->isEmpty(), 'Is empty when it should not be' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Buylinks->get( 'physicals' ), 'Affiliations are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Buylinks->get( 'downloads' ), 'Affiliations are not an instance of ArrayCollection' );
	}

	/**
	 * @return void
	 */
	public function testGetInfo()
	{
		$Album = $this->lastfm->album()->getInfo( 'The Offspring', 'Conspiracy of One' );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Album', $Album, 'Object is not the instance of Album' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Album->getImages(), 'Images are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Album->getTracks(), 'Tracks are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Album->getTopTags(), 'TopTags are not an instance of ArrayCollection' );

		$Album = $this->lastfm->album()->getInfoByMbid( '0405cb4c-fc88-3338-b5d6-1fa71a9562e4' );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Album\Album', $Album, 'Object is not the instance of Album' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Album->getImages(), 'Images are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Album->getTracks(), 'Tracks are not an instance of ArrayCollection' );
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Album->getTopTags(), 'TopTags are not an instance of ArrayCollection' );
	}

	/**
	 * @return void
	 */
	public function testGetShouts()
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
	public function testGetTags()
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
	public function testGetTopTag()
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
	public function testRemoveTag()
	{
		$status = $this->lastfm->album()->removeTag( 'Coldplay', 'Mylo Xyloto', 'great', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );

		$status = $this->lastfm->album()->removeTag( 'Coldplay', 'Mylo Xyloto', 'Awesome', $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}

	/**
	 * @return void
	 */
	public function testSearch()
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
	public function testShare()
	{
		$status = $this->lastfm->album()->share( 'Coldplay', 'Mylo Xyloto', $GLOBALS['tests_email'], $GLOBALS['auth_session_key'] );
		$this->assertEquals( 'ok', $status );
	}
}
