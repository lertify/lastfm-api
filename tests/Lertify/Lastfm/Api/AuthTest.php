<?php
namespace Lertify\Lastfm\Tests\Api;

class AuthTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'], $GLOBALS['api_secret_key'] );
	}

	public function testGetToken()
	{
		$Token = $this->lastfm->auth()->getToken();
		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Auth\Token', $Token, 'Token is not an instance of Data\Auth\Token' );
		$this->assertNotEmpty( $Token->getToken(), 'Token is empty' );
	}

	public function testGetSession()
	{
		$Session = $this->lastfm->auth()->getSession( $GLOBALS['auth_token'] );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Auth\Session', $Session, 'Session is not an instance of Data\Auth\Session' );
		$this->assertNotEmpty( $Session->getKey(), 'Session key is empty' );
	}

	public function testGetMobileSession()
	{
		$Session = $this->lastfm->auth()->getMobileSession( $GLOBALS['tests_username'], $GLOBALS['tests_password'] );

		$this->assertInstanceOf( 'Lertify\Lastfm\Api\Data\Auth\Session', $Session, 'Session is not an instance of Data\Auth\Session' );
		$this->assertNotEmpty( $Session->getKey(), 'Session key is empty' );
	}
}
