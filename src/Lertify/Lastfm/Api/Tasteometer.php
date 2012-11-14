<?php
/**
 * @author   Eugene Serkin <jeserkin@gmail.com>
 * @version  $Id:$
 */
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\ArrayCollection,
	Lertify\Lastfm\Util\Util,
	InvalidArgumentException;

class Tasteometer extends AbstractApi
{
	const
		PREFIX = 'tasteometer.';

	/**
	 * @link http://www.last.fm/api/show/tasteometer.compare
	 *
	 * @param string $typeOne
	 * @param string $typeTwo
	 * @param string|array $valueOne
	 * @param string|array $valueTwo
	 * @param int $limit
	 * @throws InvalidArgumentException
	 * @return Data\Tasteometer\Comparison
	 */
	public function compare( $typeOne, $typeTwo, $valueOne, $valueTwo, $limit = 5 )
	{
		if ( is_array( $valueOne ) )
		{
			if ( count( $valueOne ) > 100 )
			{
				throw new InvalidArgumentException( 'Number of artists is higher then allowed!' );
			}
			else
			{
				$valueOne = implode( ',', $valueOne );
			}
		}

		if ( is_array( $valueTwo ) )
		{
			if ( count( $valueTwo ) > 100 )
			{
				throw new InvalidArgumentException( 'Number of artists is higher then allowed!' );
			}
			else
			{
				$valueTwo = implode( ',', $valueTwo );
			}
		}

		$params = array(
			'type1'  => $typeOne,
			'type2'  => $typeTwo,
			'value1' => $valueOne,
			'value2' => $valueTwo,
			'limit'  => $limit,
		);

		$result           = $this->get( self::PREFIX . 'compare', $params );
		$resultComparison = $result['comparison'];

		$Comparison = new Data\Tasteometer\Comparison();
		$UsersList  = new ArrayCollection();

		if ( isset( $resultComparison['input']['user'][0] ) )
		{
			$users = $resultComparison['input']['user'];
		}
		else
		{
			$users = array( $resultComparison['input']['user'] );
		}

		foreach ( $users as $userRow )
		{
			$User = new Data\Tasteometer\User();

			$User->setName( Util::toSting( $userRow['name'] ) );
			$User->setUrl( Util::toSting( $userRow['url'] ) );

			$Images = new ArrayCollection();

			if ( isset( $userRow['image'] ) )
			{
				foreach ( $userRow['image'] as $image )
				{
					$Images->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}
			}

			$User->setImages( $Images );
			$UsersList->add( $User );
		}

		$Comparison->setInput( $UsersList );
		$Comparison->setScore( (float) $resultComparison['result']['score'] );

		$Artists      = $resultComparison['result']['artists'];
		$Comparison->setMatches( (int) $Artists['@attr']['matches'] );
		$ArtistList  = new ArrayCollection();

		if ( isset( $Artists['artist'][0] ) )
		{
			$artistsList = $Artists['artist'];
		}
		else
		{
			$artistsList = array( $Artists['artist'] );
		}

		foreach ( $artistsList as $artistRow )
		{
			$Artist = new Data\Tasteometer\Artist();

			$Artist->setName( Util::toSting( $artistRow['name'] ) );
			$Artist->setUrl( Util::toSting( $artistRow['url'] ) );

			$Images = new ArrayCollection();

			if ( isset( $artistRow['image'] ) )
			{
				foreach ( $artistRow['image'] as $image )
				{
					$Images->set( Util::toSting( $image['size'] ), Util::toSting( $image['#text'] ) );
				}
			}

			$Artist->setImages( $Images );
			$ArtistList->add( $Artist );
		}

		$Comparison->setArtists( $ArtistList );

		return $Comparison;
	}
}
