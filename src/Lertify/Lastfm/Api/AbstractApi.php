<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Client;

abstract class AbstractApi implements ApiInterface
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	private $client;

	/**
	 * @param \Lertify\Lastfm\Client $Client
	 * @return \Lertify\Lastfm\Api\AbstractApi
	 */
	public function __construct( Client $Client )
	{
		$this->client = $Client;
	}

	/**
	 * @return \Lertify\Lastfm\Client
	 */
	protected function getClient()
	{
		return $this->client;
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function get( $method, array $parameters = array(), $options = array() )
	{
		$options['json'] = true;

		return $this->client->get( $method, $parameters, $options );
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function post( $method, array $parameters = array(), $options = array() )
	{
		$options['json'] = true;

		return $this->client->post( $method, $parameters, $options );
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function put( $method, array $parameters = array(), $options = array() )
	{
		return $this->client->put( $method, $parameters, $options );
	}
}
