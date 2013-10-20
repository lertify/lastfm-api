<?php
namespace Lertify\Lastfm\Response;

class XmlResponse implements ResponseInterface
{
	/**
	 * @var \SimpleXMLElement
	 */
	protected $xml;

	/**
	 * @param string $rawResponse
	 */
	public function __construct( $rawResponse )
	{
		$this->xml = new \SimpleXMLElement( $rawResponse );
	}

	/**
	 * @return bool
	 */
	public function hasErrors()
	{
		return isset( $this->xml->error );
	}

	/**
	 * @return int
	 */
	public function getErrorCode()
	{
		$errorCode = 0;

		foreach ( $this->xml->error->attributes() as $attribute )
		{
			$errorCode = (int) $attribute;
		}

		return $errorCode;
	}

	/**
	 * @return string
	 */
	public function getErrorMessage()
	{
		if ( ! $this->hasErrors() )
		{
			return 'Unknown error message';
		}

		return trim( $this->xml->error );
	}

	/**
	 * @return string
	 */
	public function getResponse()
	{
		$xml = next( $this->xml );

		if ( is_string( $xml ) )
		{
			$xml = $this->xml;
		}

		return trim( $xml->asXml() );
	}
}