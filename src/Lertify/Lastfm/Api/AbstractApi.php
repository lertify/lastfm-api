<?php
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Client,

    JMS\Serializer\SerializerBuilder;

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
	 * @param string $class
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function get( $class, $method, array $parameters = array(), $options = array() )
	{
		return $this->deserializeResponse( $class, $this->client->get( $method, $parameters, $options ) );
	}

	/**
	 * @param string $class
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function post( $class, $method, array $parameters = array(), $options = array() )
	{
		return $this->deserializeResponse( $class, $this->client->post( $method, $parameters, $options ) );
	}

	/**
	 * @param string $class
	 * @param string $response
	 * @return mixed
	 */
	protected function deserializeResponse( $class, $response )
	{
		$class = 'Lertify\Lastfm\Api\Data\\' . $class;

		/** @var $Builder \JMS\Serializer\SerializerBuilder */
		$Builder = SerializerBuilder::create();

		$Serializer = $Builder->build();

		return $Serializer->deserialize( $response, $class, 'xml' );
	}
}
