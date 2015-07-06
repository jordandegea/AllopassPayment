<?php
namespace Sinenco\AllopassPaymentBundle\Events;

use Symfony\Component\EventDispatcher\Event;
use Sinenco\AllopassPaymentBundle\Entity\Transaction ;


class AllopassPaymentCallbackEvent extends Event
{
  protected $transaction;
  protected $first_time ; 

  public function __construct(Transaction $transaction, $first_time)
  {
    $this->transaction = $transaction;
    $this->first_time = $first_time ;
  }
  
  public function isFirstTime(){
      return $this->first_time ; 
  }
  
  public function getTransaction(){
      return $this->transaction ;
  }

}