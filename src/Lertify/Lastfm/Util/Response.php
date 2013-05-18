<?php
namespace Lertify\Lastfm\Util;

use DateTime,
	Iterator;

class Response implements Iterator
{
	/**
	 * @var array
	 */
	protected $response;

	/**
	 * @param array $response
	 */
	public function __construct( $response )
	{
		if ( ! is_array( $response ) )
		{
			$response = array( $response );
		}

		$this->response = $response;
	}

	/**
	 * @return array
	 */
	public function getRawResponse()
	{
		return $this->response;
	}

	/**
	 * @param string $path
	 * @param mixed $defaultValue
	 * @return string|\Lertify\Lastfm\Util\Response|null
	 */
	public function get( $path, $defaultValue = null )
	{
		$path         = trim( $path, '.' );
		$pathElements = explode( '.', $path );

		$value = null;

		foreach ( $pathElements as $element )
		{
			if ( null === $value && ! isset( $this->response[ $element ] ) )
			{
				continue;
			}

			if ( null === $value )
			{
				$value = $this->response[ $element ];
			}
			elseif ( isset( $value[ $element ] ) )
			{
				$value = $value[ $element ];
			}
			else
			{
				$value = null;
			}
		}

		if ( null === $value )
		{
			$value = $defaultValue;
		}

		if ( is_array( $value ) )
		{
			return new self( $value );
		}

		return $value;
	}

	/**
	 * @param string $path
	 * @param mixed $defaultValue
	 * @return bool
	 */
	public function getBool( $path, $defaultValue = null )
	{
		return (bool) $this->get( $path, $defaultValue );
	}

	/**
	 * @param string $path
	 * @param mixed $defaultValue
	 * @return float
	 */
	public function getFloat( $path, $defaultValue = null )
	{
		return (float) $this->get( $path, $defaultValue );
	}

	/**
	 * @param string $path
	 * @param mixed $defaultValue
	 * @return string
	 */
	public function getString( $path, $defaultValue = null )
	{
		return (string) $this->get( $path, $defaultValue );
	}

	/**
	 * @param string $path
	 * @param mixed $defaultValue
	 * @return int
	 */
	public function getInt( $path, $defaultValue = null )
	{
		return (int) $this->get( $path, $defaultValue );
	}

	/**
	 * @param string $path
	 * @param mixed $defaultValue
	 * @return \DateTime|null
	 */
	public function getDate( $path, $defaultValue = null )
	{
		$result = $this->get( $path, $defaultValue );

		if ( null !== $result )
		{
			if ( is_string( $result ) )
			{
				$result = new DateTime( $result );
			}
		}

		return $result;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return mixed Can return any type.
	 */
	public function current()
	{
		return new self( current( $this->response ) );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next()
	{
		next( $this->response );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key()
	{
		return key( $this->response );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid()
	{
		return ( false !== current( $this->response ) );
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind()
	{
		reset( $this->response );
	}

	/**
	 * @return string
	 */
	public function __toString()
	{
		return ( is_array( $this->response ) ? $this->response[0] : $this->response );
	}
}