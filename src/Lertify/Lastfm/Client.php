<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm;

use Lertify\Lastfm\Api,
	Lertify\Lastfm\Api\ApiInterface,
	Lertify\Lastfm\Util\Curl,
	Lertify\Lastfm\Exception\NotFoundException,
	InvalidArgumentException,
	RuntimeException;

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
	 * @param bool $https
	 * @return string
	 */
	public function getApiUrl( $https = false )
	{
		$url = $this->apiUrl;

		if ( $https )
		{
			$url = str_replace( 'http://', 'https://', $this->apiUrl );
		}

		return $url;
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
	 * @throws RuntimeException
	 * @throws NotFoundException
	 * @return array
	 */
	public function get( $method, array $parameters = array(), $options = array() )
	{
		$Curl = new Curl();
		$Curl->curlGet( $this->getApiUrl( isset( $options['https'] ) ), $this->parseRequestParameters( $method, $parameters, $options ) );

		if ( ( isset( $options['https'] ) && true === $options['https'] ) )
		{
            $Curl->setCurlParam( CURLOPT_PORT, '445' );
        }

		$response = $Curl->fetch();

		if ( false !== ( $error = $Curl->getError() ) )
		{
			throw new RuntimeException( $error );
		}

		$response = json_decode( $response, true );
		$httpCode = $Curl->getCurlInfo( CURLINFO_HTTP_CODE );

		$Curl->closeRequest();

		if ( 503 == $httpCode )
		{
            throw new RuntimeException( 'Limit exceeded' );
        }

        if( 404 == $httpCode )
		{
            throw new NotFoundException( ( isset( $response['error'] ) ? $response['error'] : 'Unknown error message' ) );
        }

		return $response;
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @throws RuntimeException
	 * @throws NotFoundException
	 * @return mixed
	 */
	public function post( $method, array $parameters = array(), $options = array() )
	{
		$Curl = new Curl();
		$Curl->curlPost( $this->getApiUrl( isset( $options['https'] ) ), $this->parseRequestParameters( $method, $parameters, $options ) );

		if ( ( isset( $options['https'] ) && true === $options['https'] ) )
		{
            $Curl->setCurlParam( CURLOPT_PORT, '445' );
        }

		$response = $Curl->fetch();

		if ( false !== ( $error = $Curl->getError() ) )
		{
			throw new RuntimeException( $error );
		}

		$response = json_decode( $response, true );
		$httpCode = $Curl->getCurlInfo( CURLINFO_HTTP_CODE );

		$Curl->closeRequest();

		if ( 503 == $httpCode )
		{
            throw new RuntimeException( 'Limit exceeded' );
        }

        if( 404 == $httpCode )
		{
            throw new NotFoundException( ( isset( $response['error'] ) ? $response['error'] : 'Unknown error message' ) );
        }

		return $response;
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function put( $method, array $parameters = array(), $options = array() )
	{
		$Curl = new Curl();
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

		if ( isset( $options['is_signed'] ) && true === $options['is_signed'] )
		{
            $parameters['api_sig'] = $this->buildSignature( $parameters );
        }

		if ( isset( $options['json'] ) )
		{
			$parameters['format'] = 'json';
		}

		return $parameters;
	}

	/**
	 * @param array $parameters
	 * @return string
	 */
	private function buildSignature( array $parameters )
	{
		ksort( $parameters );

		$signature = '';

		foreach ( $parameters as $key => $value )
		{
			$signature .= $key.$value;
		}

		return md5( $signature . $this->getApiSecretKey() );
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

			case 'auth':
			{
				return $this->auth();
			}

			/*case 'artist':
			{
				return $this->artist();
			}*/

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

	/**
	 * @return Api\Auth
	 */
	public function auth()
	{
		if ( ! isset( $this->apis['auth'] ) )
		{
			$this->apis['auth'] = new Api\Auth( $this );
		}

		return $this->apis['auth'];
	}

    /**
     * @return //Api\Artist
     */
    /*public function artist()
    {
        if ( ! isset( $this->apis['artist'] ) )
        {
            $this->apis['artist'] = new Api\Artist( $this );
        }

        return $this->apis['artist'];
    }*/

	public function clearHeaders()
	{
		$this->setHeaders( array() );
	}

	public function setHeaders( $headers )
	{
		$this->headers = $headers;
	}
}
