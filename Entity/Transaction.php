<?php

namespace Sinenco\AllopassPaymentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sinenco\AllopassPaymentBundle\Entity\CodeTransaction ; 
/**
 * Transaction
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Transaction {

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    
    /**
     * @var string
     *
     * @ORM\Column(name="data", type="string", length=100)
     */
    private $data;
    
    
    /**
     * @var timestamp
     *
     * @ORM\Column(type="datetime")
     */
    private $creation_date;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="transaction_id", type="string", length=50)
     */
    private $transaction_id;
    
    

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
     * Constructor
     */
    public function __construct()
    {
        $this->codes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set creation_date
     *
     * @param \DateTime $creationDate
     * @return Transaction
     */
    public function setCreationDate($creationDate)
    {
        $this->creation_date = $creationDate;

        return $this;
    }

    /**
     * Get creation_date
     *
     * @return \DateTime 
     */
    public function getCreationDate()
    {
        return $this->creation_date;
    }

    /**
     * Set transaction_id
     *
     * @param string $transactionId
     * @return Transaction
     */
    public function setTransactionId($transactionId)
    {
        $this->transaction_id = $transactionId;

        return $this;
    }

    /**
     * Get transaction_id
     *
     * @return string 
     */
    public function getTransactionId()
    {
        return $this->transaction_id;
    }

    /**
     * Set priceCurrency
     *
     * @param string $priceCurrency
     * @return Transaction
     */
    public function setPriceCurrency($priceCurrency)
    {
        $this->priceCurrency = $priceCurrency;

        return $this;
    }

    /**
     * Get priceCurrency
     *
     * @return string 
     */
    public function getPriceCurrency()
    {
        return $this->priceCurrency;
    }

    /**
     * Set priceAmount
     *
     * @param string $priceAmount
     * @return Transaction
     */
    public function setPriceAmount($priceAmount)
    {
        $this->priceAmount = $priceAmount;

        return $this;
    }

    /**
     * Get priceAmount
     *
     * @return string 
     */
    public function getPriceAmount()
    {
        return $this->priceAmount;
    }

    /**
     * Set payoutCurrency
     *
     * @param string $payoutCurrency
     * @return Transaction
     */
    public function setPayoutCurrency($payoutCurrency)
    {
        $this->payoutCurrency = $payoutCurrency;

        return $this;
    }

    /**
     * Get payoutCurrency
     *
     * @return string 
     */
    public function getPayoutCurrency()
    {
        return $this->payoutCurrency;
    }

    /**
     * Set payoutAmount
     *
     * @param string $payoutAmount
     * @return Transaction
     */
    public function setPayoutAmount($payoutAmount)
    {
        $this->payoutAmount = $payoutAmount;

        return $this;
    }

    /**
     * Get payoutAmount
     *
     * @return string 
     */
    public function getPayoutAmount()
    {
        return $this->payoutAmount;
    }


    /**
     * Set data
     *
     * @param string $data
     * @return Transaction
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return string 
     */
    public function getData()
    {
        return $this->data;
    }
}
