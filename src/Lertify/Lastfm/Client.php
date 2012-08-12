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
     * The list of loaded API instances
     *
     * @var array
     */
    private $apis = array();

	/**
	 * @param string $apiKey
	 */
	public function __construct( $apiKey )
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
	 * @param string $path
	 * @param array $parameters
	 * @param array $options
	 * @return mixed
	 */
	public function get( $path, array $parameters = array(), $options = array() )
	{
		$ch = curl_init();

		$defaultParameters = array(
			'api_key'  => $this->apiKey,
        );

		$parameters = array_merge( $defaultParameters, $parameters );
		$query      = http_build_query( $parameters );

		curl_setopt_array( $ch, array(
			CURLOPT_URL            => $this->apiUrl . '?' . $query,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_HEADER         => false,
			CURLOPT_FAILONERROR    => true,
		) );

		return curl_exec( $ch );
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