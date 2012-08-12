<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Client;

abstract class AbstractApi implements ApiInterface
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	private $client;

	/**
	 * @param \Lertify\Lastfm\Client $client
	 */
	public function __construct( Client $client )
	{
		$this->client = $client;
	}

	/**
	 * @param string $path
	 * @param array $parameters
	 * @param array $requestOptions
	 * @return mixed
	 */
	protected function get( $path, array $parameters = array(), $requestOptions = array() )
	{
		return $this->client->get( $path, $parameters, $requestOptions );
	}

	/**
	 * @return \Lertify\Lastfm\Client
	 */
	protected function getClient()
	{
		return $this->client;
	}
}