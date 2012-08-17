<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm;

use Lertify\Lastfm\Api;
use Lertify\Lastfm\Api\ApiInterface;

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
	 * @var
	 */
	private $secretKey;

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
        $this->apiUrl = self::URL . self::VERSION;
		$this->apiKey = $apiKey;
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