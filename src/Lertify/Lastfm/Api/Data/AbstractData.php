<?php
namespace Lertify\Lastfm\Api\Data;

use Exception,
	ReflectionProperty;

abstract class AbstractData
{
	/**
	 * @param array $data
	 */
	public function __construct( $data = array() )
	{
		if ( ! empty( $data ) )
		{
			$this->fromArray( $data );
		}
	}

	/**
	 * @param string $key
	 * @param array $arguments
	 * @throws \Exception
	 * @return mixed
	 */
	public function __call( $key, array $arguments )
	{
		if ( method_exists( $this, $key ) )
		{
			return call_user_func_array( array( $this, $key ), $arguments );
		}

		if ( property_exists( $this, $key ) )
		{
			if ( 0 == count( $arguments ) )
			{
				return $this->__get( $key );
			}
			elseif ( 1 == count( $arguments ) )
			{
				return $this->__set( $key, $arguments[0] );
			}
		}

		if ( 'set' == $key && 2 == count( $arguments ) )
		{
			return $this->__set( $arguments[0], $arguments[1] );
		}

		if ( 'get' == $key && 1 == count( $arguments ) )
		{
			return $this->__get( $arguments[0] );
		}

		if ( 'set' == substr( $key, 0, 3 ) && 1 == count( $arguments ) )
		{
			return $this->__set( lcfirst( substr( $key, 3 ) ) , $arguments[0] );
		}

		if ( 'get' == substr( $key, 0, 3 ) && 0 == count( $arguments ) )
		{
			return $this->__get( lcfirst( substr( $key, 3 ) ) );
		}

		throw new Exception( 'Undefined method ' . $key . "!");
	}

	/**
	 * @param string $key
	 * @param mixed $value
	 * @throws \Exception
	 * @return \Lertify\Lastfm\Api\Data\AbstractData
	 */
	public function __set( $key, $value )
	{
		$uncamelizedKey = $this->uncamelize( $key );

		if ( property_exists( $this, $uncamelizedKey ) )
		{
			$camelizedName = 'set' . $this->camelize( $key );

			if ( method_exists( $this, $camelizedName ) )
			{
				$this->{ $camelizedName }( $value );
			}
			else
			{
				$this->{ $uncamelizedKey } = $value;
			}
		}
		else
		{
			 throw new Exception( 'Undefined property ' . $key . ' (' . $uncamelizedKey . ')!');
		}

		return $this;
	}

	/**
	 * @param string $key
	 * @throws \Exception
	 * @return mixed
	 */
	public function __get( $key )
	{
		$uncamelizedKey = $this->uncamelize( $key );

		if ( property_exists( $this, $uncamelizedKey ) )
		{
			$camelizedName = 'get' . $this->camelize( $key );

			if ( method_exists( $this, $camelizedName ) )
			{
				return $this->{ $camelizedName }();
			}
			else
			{
				return $this->{ $uncamelizedKey };
			}
		}
		else
		{
			 throw new Exception( 'Undefined property ' . $key . ' (' . $uncamelizedKey . ')!' );
		}
	}

	/**
	 * @return array
	 */
	public function toArray()
	{
		$value = get_object_vars( $this );

		foreach ( $value as $key => $value )
		{
			$Property = new ReflectionProperty( $this, $key );

			if ( $Property->isProtected() )
			{
				unset( $value[ $key ] );
			}
		}

		return $value;
	}

	/**
	 * @param array $array
	 * @return \Lertify\Lastfm\Api\Data\AbstractData
	 */
	public function fromArray( array $array )
	{
		foreach ( $array as $key => $value )
		{
			$this->{ $key } = $value;
		}

		return $this;
	}

	/**
	 * @param string|array $word
	 * @return string|array
	 */
	private function camelize( $word )
	{
		return preg_replace_callback( '#(^|_)([a-z])#', function( array $matches )
		{
			return strtoupper( $matches[2] );
		}, $word );
	}

	/**
	 * @param string $camel
	 * @return string
	 */
	private function uncamelize( $camel )
	{
		return strtolower( preg_replace( '#([a-zA-Z])(?=[A-Z])#', '$1_', $camel ) );
	}
}