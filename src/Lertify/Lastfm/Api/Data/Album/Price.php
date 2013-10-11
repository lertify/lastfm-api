<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

class Price
{
	/**
     * @JMS\Type("string")
	 * @var string
     */
    protected $currency;

    /**
     * @JMS\Type("string")
     * @var float
     */
    protected $amount;

    /**
     * @JMS\Type("string")
     * @var string
     */
    protected $formatted;

	/**
	 * @return string
	 */
	public function getCurrency()
	{
		return $this->currency;
	}

	/**
	 * @return float
	 */
	public function getAmount()
	{
		return $this->amount;
	}

	/**
	 * @return string
	 */
	public function getFormatted()
	{
		return $this->formatted;
	}
}