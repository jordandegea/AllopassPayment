<?php

namespace Sinenco\AllopassPaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PricePoint
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class PricePoint {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    
    /**
     * @var integer
     *
     * @ORM\Column(name="price_id", type="integer")
     */
    private $priceId;
    
    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=5)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=30)
     */
    private $category;

    /**
     * @var string
     *
     * @ORM\Column(name="price_currency", type="string", length=5)
     */
    private $priceCurrency;

    /**
     * @var string
     *
     * @ORM\Column(name="price_amount", type="decimal", precision=10, scale=2)
     */
    private $priceAmount;

    /**
     * @var string
     *
     * @ORM\Column(name="payout_currency", type="string", length=5)
     */
    private $payoutCurrency;

    /**
     * @var string
     *
     * @ORM\Column(name="payout_amount", type="decimal", precision=10, scale=2)
     */
    private $payoutAmount;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param integer $id
     * @return PricePoint
     */
    public function setId($id) {
        $this->id = $id;
        return $this;
    }
    
    /**
     * Get priceId
     *
     * @return integer 
     */
    public function getPriceId() {
        return $this->priceId;
    }

    /**
     * Set priceId
     *
     * @param integer $priceId
     * @return PricePoint
     */
    public function setPriceId($priceId) {
        $this->priceId = $priceId;
        return $this;
    }

    /**
     * Set country
     *
     * @param string $country
     * @return PricePoint
     */
    public function setCountry($country) {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string 
     */
    public function getCountry() {
        return $this->country;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return PricePoint
     */
    public function setType($type) {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType() {
        return $this->type;
    }

    /**
     * Set category
     *
     * @param string $category
     * @return PricePoint
     */
    public function setCategory($category) {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return string 
     */
    public function getCategory() {
        return $this->category;
    }

    /**
     * Set priceCurrency
     *
     * @param string $priceCurrency
     * @return PricePoint
     */
    public function setPriceCurrency($priceCurrency) {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    /**
     * Get priceCurrency
     *
     * @return string 
     */
    public function getPriceCurrency() {
        return $this->priceCurrency;
    }

    /**
     * Set priceAmount
     *
     * @param string $priceAmount
     * @return PricePoint
     */
    public function setPriceAmount($priceAmount) {
        $this->priceAmount = $priceAmount;

        return $this;
    }

    /**
     * Get priceAmount
     *
     * @return string 
     */
    public function getPriceAmount() {
        return $this->priceAmount;
    }

    /**
     * Set payoutCurrency
     *
     * @param string $payoutCurrency
     * @return PricePoint
     */
    public function setPayoutCurrency($payoutCurrency) {
        $this->payoutCurrency = $payoutCurrency;

        return $this;
    }

    /**
     * Get payoutCurrency
     *
     * @return string 
     */
    public function getPayoutCurrency() {
        return $this->payoutCurrency;
    }

    /**
     * Set payoutAmount
     *
     * @param string $payoutAmount
     * @return PricePoint
     */
    public function setPayoutAmount($payoutAmount) {
        $this->payoutAmount = $payoutAmount;

        return $this;
    }

    /**
     * Get payoutAmount
     *
     * @return string 
     */
    public function getPayoutAmount() {
        return $this->payoutAmount;
    }

}
