<?php
namespace Lertify\Lastfm\Response;

use Exception;

class JsonResponse implements ResponseInterface
{
	/**
	 * @param string $rawResponse
	 * @throws \Exception
	 */
	public function __construct( $rawResponse )
	{
		throw new Exception( 'Not implemented at the moment!' );
	}

	/**
	 * @return bool
	 */
	public function hasErrors()
	{
		// TODO: Implement hasErrors() method.
	}

	/**
	 * @return int
	 */
	public function getErrorCode()
	{
		// TODO: Implement getErrorCode() method.
	}

	/**
	 * @return string
	 */
	public function getErrorMessage()
	{
		// TODO: Implement getErrorMessage() method.
	}

	/**
	 * @return string
	 */
	public function getResponse()
	{
		// TODO: Implement getResponse() method.
	}
}