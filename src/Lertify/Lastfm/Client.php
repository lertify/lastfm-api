<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm;

use Lertify\Lastfm\Api,
	Lertify\Lastfm\Api\ApiInterface,
	InvalidArgumentException;

class Client
{
	const
		VERSION = '2.0',
		URL     = 'http://ws.audioscrobbler.com/';

	/**
	 * @var string
	 */
	private $apiUrl;

	/**
	 * @var string
	 */
	private $apiKey;

	/**
	 * @var string
	 */
	private $apiSecretKey;

	/**
	 * The list of loaded API instances
	 *
	 * @var array
	 */
	private $apis = array();

	/**
	 * @param string $apiKey
	 * @param string $apiSecretKey
	 */
	public function __construct( $apiKey, $apiSecretKey )
	{
		$this->apiUrl       = self::URL . self::VERSION;
		$this->apiKey       = $apiKey;
		$this->apiSecretKey = $apiSecretKey;
	}

	/**
	 * @return string
	 */
	public function getApiUrl()
	{
		return $this->apiUrl;
	}

	/**
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->apiKey;
	}

	/**
	 * @return string
	 */
	public function getApiSecretKey()
	{
		return $this->apiSecretKey;
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function get( $method, array $parameters = array(), $options = array() )
	{
		$Curl = new \Lertify\Lastfm\Util\Curl();
		$Curl->curlGet( $this->getApiUrl(), $this->parseRequestParameters( $method, $parameters, $options ) );

		return $Curl->fetch();
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function post( $method, array $parameters = array(), $options = array() )
	{
		$Curl = new \Lertify\Lastfm\Util\Curl();
		$Curl->curlPost( $this->getApiUrl(), $this->parseRequestParameters( $method, $parameters, $options ) );

		return $Curl->fetch();
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function put( $method, array $parameters = array(), $options = array() )
	{
		$Curl = new \Lertify\Lastfm\Util\Curl();
		$Curl->curlPut( $this->getApiUrl(), $this->parseRequestParameters( $method, $parameters, $options ) );

		return $Curl->fetch();
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return array
	 */
	private function parseRequestParameters( $method, array $parameters = array(), $options = array() )
	{
		$defaultParameters = array(
			'api_key'  => $this->apiKey,
		);

		$parameters['method'] = $method;
		$parameters           = array_merge( $defaultParameters, $parameters );

		return $parameters;
	}

	/**
	 * @param string $apiName
	 * @throws InvalidArgumentException
	 * @return Api\AbstractApi
	 */
	public function api( $apiName )
	{
		switch ( $apiName )
		{
			case 'album':
			{
				return $this->album();
			}

			default:
			{
				throw new InvalidArgumentException( 'No such api at present time!' );
			}
		}
	}

	/**
	 * @return Api\Album
	 */
	public function album()
	{
		if ( ! isset( $this->apis['album'] ) )
		{
			$this->apis['album'] = new Api\Album( $this );
		}

		return $this->apis['album'];
	}

	public function clearHeaders()
	{
		$this->setHeaders( array() );
	}

	public function setHeaders( $headers )
	{
		$this->headers = $headers;
	}
}
