<?php
/**
 * @author  Eugene Serkin <jserkin@gmail.com>
 * @version $Id$
 */
namespace Lertify\Lastfm\Tests;

class ClientTest extends \PHPUnit_Framework_TestCase
{
	/**
	 * @var \Lertify\Lastfm\Client
	 */
	protected $lastfm;

	protected function setUp()
	{
		$this->lastfm = new \Lertify\Lastfm\Client( $GLOBALS['api_key'] );
	}

	/**
	 * @throws \Exception
	 */
	public function testGetConfiguration()
	{
		throw new \Exception( 'TODO Implement Me' );
	}
}