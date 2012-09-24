<?php
/**
 * @author  Eugene Serkin <jeserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Api;

use Lertify\Lastfm\Api\Data\Auth\Token,
	Lertify\Lastfm\Api\Data\Auth\Session,
	Lertify\Lastfm\Util\Util;

class Auth extends AbstractApi
{
	const
		PREFIX = 'auth.';

	/**
	 * @link http://www.last.fm/api/show/auth.getToken
	 *
	 * @return Token
	 */
	public function getToken()
	{
		$result = $this->get( self::PREFIX . 'getToken', array(), array( 'is_signed' => true ) );
		$Token  = new Token();

		$Token->setToken( Util::toSting( $result['token'] ) );

		return $Token;
	}

	/**
	 * @link http://www.last.fm/api/show/auth.getSession
	 *
	 * @param string $token
	 * @return Session
	 */
	public function getSession( $token )
	{
		$result        = $this->get( self::PREFIX . 'getSession', array( 'token' => $token ), array( 'is_signed' => true ) );
		$resultSession = $result['session'];

		$Session = new Session();

		$Session->setName( Util::toSting( $resultSession['name'] ) );
		$Session->setKey( Util::toSting( $resultSession['key'] ) );
		$Session->setSubscriber( (int) $resultSession['subscriber'] );

		return $Session;
	}

	/**
	 * @link http://www.last.fm/api/show/auth.getMobileSession
	 *
	 * @param string $username
	 * @param string $password
	 * @return Session
	 */
	public function getMobileSession( $username, $password )
	{
		// @todo doesnt work, timeout occurs
		$result = $this->post( self::PREFIX . 'getSession', array(
			'username' => $username,
			'password' => $password,
		), array(
			'is_signed' => true,
			'https'     => true,
		) );
		$resultSession = $result['session'];

		$Session = new Session();

		$Session->setName( Util::toSting( $resultSession['name'] ) );
		$Session->setKey( Util::toSting( $resultSession['key'] ) );
		$Session->setSubscriber( (int) $resultSession['subscriber'] );

		return $Session;
	}
}
