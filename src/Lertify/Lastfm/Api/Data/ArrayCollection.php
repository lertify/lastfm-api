<?php
namespace Lertify\Lastfm\Api\Data;

use ArrayIterator;

class ArrayCollection implements Collection
{
	/**
     * Items of the collection.
     * @var array
     */
    protected $items;

	/**
     * Create ArrayCollection.
	 *
     * @param array $items collection items
     */
    public function __construct( array $items = array() )
    {
        $this->items = $items;
    }

	/**
     * Get collection item by key
	 *
     * @param mixed $key item key
     * @return mixed|null
     */
	public function get( $key )
	{
		if ( isset( $this->items[ $key ] ) )
		{
            return $this->items[ $key ];
        }

        return null;
	}

	/**
     * Add an item to the collection
	 *
     * @param mixed $item
     * @return ArrayCollection
     */
	public function add( $item )
	{
		$this->items[] = $item;

        return $this;
	}

	/**
     * Add collection item at the index
	 *
     * @param mixed $key item index
     * @param mixed $value item value
     * @return ArrayCollection
     */
	public function set( $key, $value )
	{
		$this->items[ $key ] = $value;

        return $this;
	}

	/**
     * Remove an element from the collection by key
	 *
     * @param mixed $key item key
     * @return mixed|null Removed item or NULL
     */
	public function remove( $key )
	{
		if ( ! isset( $this->items[ $key ] ) )
		{
			return null;
		}

        $item = $this->items[ $key ];
        unset( $this->items[ $key ] );

        return $item;
	}

	/**
     * Clear the collection
	 *
     * @return ArrayCollection
     */
	public function clear()
	{
		$this->items = array();

        return $this;
	}

	/**
	 * Get current key, current iterator position
	 *
	 * @return mixed
	 */
	public function key()
	{
		return key( $this->items );
	}

	/**
	 * Get collection item, at current iterator position
	 *
	 * @return mixed
	 */
	public function current()
	{
		return current( $this->items );
	}

	/**
     * Get first collection item, resets the iterator position to the first element
	 *
     * @return mixed
     */
	public function first()
	{
		return reset( $this->items );
	}

	/**
     * Get next collection item, moves iterator position to the next element
	 *
     * @return mixed
     */
	public function next()
	{
		return next( $this->items );
	}

	/**
     * Get last collection item, sets iterator position to the last element
	 *
     * @return mixed
     */
	public function last()
	{
		return end( $this->items );
	}

	/**
     * Check if the collection is empty
	 *
     * @return bool
     */
	public function isEmpty()
	{
		return ! $this->items;
	}

	/**
     * Check if collection has key
	 *
     * @param mixed $key
     * @return bool
     */
	public function hasKey( $key )
	{
		return isset( $this->items[ $key ] );
	}

	/**
     * Get all keys of the collection items
	 *
     * @return array
     */
    public function getKeys()
    {
        return array_keys( $this->items );
    }

    /**
     * Get all values of the collection items
	 *
     * @return array
     */
    public function getValues()
    {
        return array_values( $this->items );
    }

	/**
     * Get php array of the collection
	 *
     * @return array
     */
	public function toArray()
	{
		return $this->items;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Retrieve an external iterator
	 * @link http://php.net/manual/en/iteratoraggregate.getiterator.php
	 * @return \Traversable An instance of an object implementing <b>Iterator</b> or
	 * <b>Traversable</b>
	 */
	public function getIterator()
	{
		return new ArrayIterator( $this->items );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Whether a offset exists
	 * @link http://php.net/manual/en/arrayaccess.offsetexists.php
	 * @param mixed $offset <p>
	 * An offset to check for.
	 * </p>
	 * @return boolean true on success or false on failure.
	 * </p>
	 * <p>
	 * The return value will be casted to boolean if non-boolean was returned.
	 */
	public function offsetExists( $offset )
	{
		return $this->hasKey( $offset );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to retrieve
	 * @link http://php.net/manual/en/arrayaccess.offsetget.php
	 * @param mixed $offset <p>
	 * The offset to retrieve.
	 * </p>
	 * @return mixed Can return all value types.
	 */
	public function offsetGet( $offset )
	{
		return $this->get( $offset );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to set
	 * @link http://php.net/manual/en/arrayaccess.offsetset.php
	 * @param mixed $offset <p>
	 * The offset to assign the value to.
	 * </p>
	 * @param mixed $value <p>
	 * The value to set.
	 * </p>
	 * @return void
	 */
	public function offsetSet( $offset, $value )
	{
		if ( ! isset( $offset ) )
		{
            $this->add( $value );
        }

        $this->set( $offset, $value );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Offset to unset
	 * @link http://php.net/manual/en/arrayaccess.offsetunset.php
	 * @param mixed $offset <p>
	 * The offset to unset.
	 * </p>
	 * @return void
	 */
	public function offsetUnset( $offset )
	{
		$this->remove( $offset );
	}

	/**
	 * (PHP 5 &gt;= 5.1.0)<br/>
	 * Count elements of an object
	 * @link http://php.net/manual/en/countable.count.php
	 * @return int The custom count as an integer.
	 * </p>
	 * <p>
	 * The return value is cast to an integer.
	 */
	public function count()
	{
		return count( $this->items );
	}
}
