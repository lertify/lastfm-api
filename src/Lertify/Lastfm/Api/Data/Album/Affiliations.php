<?php
namespace Lertify\Lastfm\Api\Data\Album;

use JMS\Serializer\Annotation as JMS;

/**
 * @JMS\XmlRoot("affiliation")
 */
class Affiliations
{
	/**
     * @JMS\Type("string")
     * @JMS\SerializedName("supplierName")
	 * @var string
     */
	protected $supplierName;

    /**
     * @JMS\Type("Lertify\Lastfm\Api\Data\Album\Price")
     * @var \Lertify\Lastfm\Api\Data\Album\Price
     */
	protected $price;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("buyLink")
     * @var string
     */
	protected $buyLink;

    /**
     * @JMS\Type("string")
     * @JMS\SerializedName("supplierIcon")
     * @var string
     */
	protected $supplierIcon;

    /**
     * @JMS\Type("integer")
     * @JMS\SerializedName("isSearch")
     * @var int
     */
	protected $isSearch;

	/**
	 * @return string
	 */
	public function getSupplierName()
	{
		return $this->supplierName;
	}

	/**
	 * @return \Lertify\Lastfm\Api\Data\Album\Price
	 */
	public function getPrice()
	{
		return $this->price;
	}

	/**
	 * @return string
	 */
	public function getBuyLink()
	{
		return $this->buyLink;
	}

	/**
	 * @return string
	 */
	public function getSupplierIcon()
	{
		return $this->supplierIcon;
	}

	/**
	 * @return int
	 */
	public function getIsSearch()
	{
		return $this->isSearch;
	}
}