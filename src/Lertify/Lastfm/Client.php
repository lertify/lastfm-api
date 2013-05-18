<?php
namespace Lertify\Lastfm;

use Lertify\Lastfm\Api,
	Lertify\Lastfm\Util\Curl,
	Lertify\Lastfm\Exception\NotFoundException,
	Lertify\Lastfm\Exception\StatusCodeException,
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
	 * @throws StatusCodeException
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

		/**
		 * Process error codes
		 * @link http://www.last.fm/api/errorcodes
		 */
		if ( isset( $response['error'] ) )
		{
			throw new StatusCodeException( $response['message'], $response['error'] );
		}

		return $response;
	}

	/**
	 * @param string $method
	 * @param array $parameters
	 * @param array $options
	 * @throws RuntimeException
	 * @throws NotFoundException
	 * @throws StatusCodeException
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

		/**
		 * Process error codes
		 * @link http://www.last.fm/api/errorcodes
		 */
		if ( isset( $response['error'] ) )
		{
			throw new StatusCodeException( $response['message'], $response['error'] );
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

			case 'artist':
			{
				return $this->artist();
			}

			case 'chart':
			{
				return $this->chart();
			}

			case 'event':
			{
				return $this->event();
			}

			case 'geo':
			{
				return $this->geo();
			}

			case 'group':
			{
				return $this->group();
			}

			case 'playlist':
			{
				return $this->playlist();
			}

			case 'radio':
			{
				return $this->radio();
			}

			case 'tasteometer':
			{
				return $this->tasteometer();
			}

			case 'venue':
			{
				return $this->venue();
			}

			case 'library':
			{
				return $this->library();
			}

			case 'tag':
			{
				return $this->tag();
			}

			case 'track':
			{
				return $this->track();
			}

			case 'user':
			{
				return $this->user();
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
     * @return Api\Artist
     */
    public function artist()
    {
        if ( ! isset( $this->apis['artist'] ) )
        {
            $this->apis['artist'] = new Api\Artist( $this );
        }

        return $this->apis['artist'];
    }

	/**
	 * @return Api\Chart
	 */
	public function chart()
	{
		if ( ! isset( $this->apis['chart'] ) )
        {
            $this->apis['chart'] = new Api\Chart( $this );
        }

        return $this->apis['chart'];
	}

	/**
	 * @return Api\Event
	 */
	public function event()
	{
		if ( ! isset( $this->apis['event'] ) )
        {
            $this->apis['event'] = new Api\Event( $this );
        }

        return $this->apis['event'];
	}

	/**
	 * @return Api\Geo
	 */
	public function geo()
	{
		if ( ! isset( $this->apis['geo'] ) )
        {
            $this->apis['geo'] = new Api\Geo( $this );
        }

        return $this->apis['geo'];
	}

	/**
	 * @return Api\Group
	 */
	public function group()
	{
		if ( ! isset( $this->apis['group'] ) )
		{
			$this->apis['group'] = new Api\Group( $this );
		}

		return $this->apis['group'];
	}

	/**
	 * @return Api\Playlist
	 */
	public function playlist()
	{
		if ( ! isset( $this->apis['playlist'] ) )
		{
			$this->apis['playlist'] = new Api\Playlist( $this );
		}

		return $this->apis['playlist'];
	}

	/**
	 * @return Api\Radio
	 */
	public function radio()
	{
		if ( ! isset( $this->apis['radio'] ) )
		{
			$this->apis['radio'] = new Api\Radio( $this );
		}

		return $this->apis['radio'];
	}

	/**
	 * @return Api\Tasteometer
	 */
	public function tasteometer()
	{
		if ( ! isset( $this->apis['tasteometer'] ) )
		{
			$this->apis['tasteometer'] = new Api\Tasteometer( $this );
		}

		return $this->apis['tasteometer'];
	}

	/**
	 * @return Api\Venue
	 */
	public function venue()
	{
		if ( ! isset( $this->apis['venue'] ) )
		{
			$this->apis['venue'] = new Api\Venue( $this );
		}

		return $this->apis['venue'];
	}

	/**
	 * @return Api\Library
	 */
	public function library()
	{
		if ( ! isset( $this->apis['library'] ) )
		{
			$this->apis['library'] = new Api\Library( $this );
		}

		return $this->apis['library'];
	}

	/**
	 * @return Api\Tag
	 */
	public function tag()
	{
		if ( ! isset( $this->apis['tag'] ) )
		{
			$this->apis['tag'] = new Api\Tag( $this );
		}

		return $this->apis['tag'];
	}

	/**
	 * @return Api\Track
	 */
	public function track()
	{
		if ( ! isset( $this->apis['track'] ) )
		{
			$this->apis['track'] = new Api\Track( $this );
		}

		return $this->apis['track'];
	}

	/**
	 * @return Api\User
	 */
	public function user()
	{
		if ( ! isset( $this->apis['user'] ) )
		{
			$this->apis['user'] = new Api\User( $this );
		}

		return $this->apis['user'];
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
