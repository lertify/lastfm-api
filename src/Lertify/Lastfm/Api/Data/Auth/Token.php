<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api\Data\Auth;

class Token
{
	/**
	 * @var string
	 */
	private $token;

	/**
	 * @param string $token
	 */
	public function setToken( $token )
	{
		$this->token = $token;
	}

	/**
	 * @return string
	 */
	public function getToken()
	{
		return $this->token;
	}
}
