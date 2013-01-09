<?php
namespace Lertify\Lastfm\Api\Data\Album;

class Affiliation
{
	/**
	 * @var string
	 */
	private $supplierName;

	/**
	 * @var string
	 */
	private $priceCurrency;

	/**
	 * @var float
	 */
	private $priceAmount;

	/**
	 * @var string
	 */
	private $buyLink;

	/**
	 * @var string
	 */
	private $supplierIcon;

	/**
	 * @var bool
	 */
	private $isSearch;

	/**
	 * @param string $supplierName
	 */
	public function setSupplierName( $supplierName )
	{
		$this->supplierName = $supplierName;
	}

	/**
	 * @return string
	 */
	public function getSupplierName()
	{
		return $this->supplierName;
	}

	/**
	 * @param string $priceCurrency
	 */
	public function setPriceCurrency( $priceCurrency )
	{
		$this->priceCurrency = $priceCurrency;
	}

	/**
	 * @return string
	 */
	public function getPriceCurrency()
	{
		return $this->priceCurrency;
	}

	/**
	 * @param float $priceAmount
	 */
	public function setPriceAmount( $priceAmount )
	{
		$this->priceAmount = $priceAmount;
	}

	/**
	 * @return float
	 */
	public function getPriceAmount()
	{
		return $this->priceAmount;
	}

	/**
	 * @param string $buyLink
	 */
	public function setBuyLink( $buyLink )
	{
		$this->buyLink = $buyLink;
	}

	/**
	 * @return string
	 */
	public function getBuyLink()
	{
		return $this->buyLink;
	}

	/**
	 * @param string $supplierIcon
	 */
	public function setSupplierIcon( $supplierIcon )
	{
		$this->supplierIcon = $supplierIcon;
	}

	/**
	 * @return string
	 */
	public function getSupplierIcon()
	{
		return $this->supplierIcon;
	}

	/**
	 * @param boolean $isSearch
	 */
	public function setIsSearch( $isSearch )
	{
		$this->isSearch = $isSearch;
	}

	/**
	 * @return boolean
	 */
	public function getIsSearch()
	{
		return $this->isSearch;
	}
}
