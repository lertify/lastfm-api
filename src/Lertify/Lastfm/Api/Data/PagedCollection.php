<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data;

use Closure,
	InvalidArgumentException;

class PagedCollection
{
	/**
	 * Items of the collection.
	 *
	 * @var Closure
	 */
	private $callback;

	/**
	 * @var array
	 */
	private $pages = array();

	/**
	 * @var int
	 */
	private $totalPages;

	/**
	 * @var int
	 */
	private $totalResults;

	/**
	 * @var int
	 */
	private $limit;

	/**
	 * Create ArrayCollection.
	 *
	 * @param Closure $Callback page retrieve callback
	 */
	public function __construct( Closure $Callback )
	{
		$this->callback = $Callback;
	}

	private function warmUp()
	{
		// Load first page, to get the total pages and results count
		$this->loadPage( 1 );
    }

	/**
	 * @param int $number
	 * @return bool
	 * @throws InvalidArgumentException
	 */
	private function loadPage( $number )
	{
		$pageData = call_user_func( $this->callback, $number, $this->getLimit() );

		if ( null === $pageData )
		{
			return false;
		}

		if ( ! isset( $pageData['results'] ) || ! isset( $pageData['total_pages'] ) || ! isset( $pageData['total_results'] ) )
		{
			throw new InvalidArgumentException( 'Paged collection callback parameters are incorrect' );
		}

		$this->pages[ $number ] = $pageData['results'];
		$this->totalPages       = intval( $pageData['total_pages'] );
		$this->totalResults     = intval( $pageData['total_results'] );

		return true;
	}

	/**
     * Get items on page
	 *
     * @param int $number Page number
     * @return ArrayCollection|null
     */
	public function getPage( $number )
	{
		if ( ! isset( $this->pages[ $number ] ) && ! $this->loadPage( $number ) )
		{
			return null;
		}

		return $this->pages[ $number ];
	}

	/**
     * Check if the collection is empty
	 *
     * @return bool
     */
	public function isEmpty()
	{
		return ( 0 === $this->count() );
	}

	/**
     * Get total items count
	 *
     * @return int
     */
    public function count()
    {
		if ( null === $this->totalResults )
		{
			$this->warmUp();
		}

		return $this->totalResults;
	}

	/**
     * Get pages count
	 *
     * @return int
     */
    public function countPages()
    {
		if ( null === $this->totalPages )
		{
			$this->warmUp();
		}

		return $this->totalPages;
	}

	/**
	 * @param int $limit
	 */
	public function setLimit( $limit )
	{
		$this->limit = $limit;
	}

	/**
	 * @return int
	 */
	public function getLimit()
	{
		return $this->limit;
	}
}
