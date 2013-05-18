<?php
namespace Lertify\Lastfm\Tests\Api;

use Lertify\Lastfm\Tests\Setup;

class TasteometerTest extends Setup
{
	public function testCompare()
	{
		$Comparison = $this->lastfm->tasteometer()->compare( 'user', 'user', 'jserkin', 'tburny' );
		$this->assertComparison( $Comparison );

		$Comparison = $this->lastfm->tasteometer()->compare( 'artists', 'user', array( 'Cher' ), 'tburny' );
		$this->assertComparison( $Comparison );
	}

	/**
	 * @param \Lertify\Lastfm\Api\Data\Tasteometer\Comparison $Comparison
	 * @return void
	 */
	private function assertComparison( \Lertify\Lastfm\Api\Data\Tasteometer\Comparison $Comparison )
	{
		$Input = $Comparison->getInput();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $Input, 'Input is not an instance of Data\ArrayCollection!' );

		/** @var $User \Lertify\Lastfm\Api\Data\Tasteometer\User */
		foreach ( $Input as $User )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tasteometer\User', $User, 'User is not an instance of Data\Tasteometer\User!' );

			$UserImages = $User->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $UserImages, 'UserImages are not an instance of Data\ArrayCollection!' );
		}

		$MatchedArtists = $Comparison->getArtists();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $MatchedArtists, 'MatchedArtists are not an instance of Data\ArrayCollection!' );

		/** @var $Artist \Lertify\Lastfm\Api\Data\Tasteometer\Artist */
		foreach ( $MatchedArtists as $Artist )
		{
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Tasteometer\Artist', $Artist, 'Artist is not an instance of Data\Tasteometer\User!' );

			$ArtistImages = $Artist->getImages();
			$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\ArrayCollection', $ArtistImages, 'ArtistImages are not an instance of Data\ArrayCollection!' );
		}
	}
}
