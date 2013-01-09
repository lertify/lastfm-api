<?php
namespace Lertify\Lastfm\Api\Data\Auth;

class Session
{
	/**
	 * @var string
	 */
	private $name;

	/**
	 * @var string
	 */
	private $key;

	/**
	 * @var int
	 */
	private $subscriber;

	/**
	 * @param string $name
	 */
	public function setName( $name )
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $key
	 */
	public function setKey( $key )
	{
		$this->key = $key;
	}

	/**
	 * @return string
	 */
	public function getKey()
	{
		return $this->key;
	}

	/**
	 * @param int $subscriber
	 */
	public function setSubscriber( $subscriber )
	{
		$this->subscriber = $subscriber;
	}

	/**
	 * @return int
	 */
	public function getSubscriber()
	{
		return $this->subscriber;
	}
}
