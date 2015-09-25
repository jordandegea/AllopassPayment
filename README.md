# AllopassPayment

(Use sinenco/allopassapi package)


# Installation in Composer
add in composer require : 
   "sinenco/AllopassPayment" : "1.*"

# Configuration

## AppKernel
    new Sinenco\AllopassPaymentBundle\SinencoAllopassPaymentBundle(),
    new Sinenco\AllopassAPIBundle\SinencoAllopassAPIBundle()

## Parameters 

### AllopassPayment
    parameters:
        allopass_payment.site_id: "Your site ID"
        allopass_payment.product_name: "Your Product Name"
        sinenco.allopass_payments.return_route: "Your controller page for return"

When a user pay with allopass, he will be redirected to this page. 
With GET parameters : RECALL, data, code, trxid, transaction_id.
The transaction is not checked with return URL but with callback url. 

### AllopassAPI 
    parameters:
        allopassAPI.api_key: "your api key"
        allopassAPI.secret_key: "your secret key"

        allopassAPI.default_hash: "sha1"
        allopassAPI.default_format: "xml"
        allopassAPI.network_timeout: "30"
        allopassAPI.network_protocol: "http"
        allopassAPI.network_port: "80"
        allopassAPI.host: "api.allopass.com"

You can use HTTPS with 443 too

## Service to add
    services:
        sinenco_allopass_api.init:
            class: Sinenco\AllopassAPIBundle\Model\AllopassApiConf
            arguments: 
                api_key: %allopassAPI.api_key%
                secret_key: %allopassAPI.secret_key%
                default_hash: %allopassAPI.default_hash%
                default_format: %allopassAPI.default_format%
                network_timeout: %allopassAPI.network_timeout%
                network_protocol: %allopassAPI.network_protocol%
                network_port: %allopassAPI.network_port%
                host: %allopassAPI.host%

## Route to add
    sinenco_allopass_payment:
        resource: '@SinencoAllopassPaymentBundle/Resources/config/routing.yml'
        prefix: /


# Installation and Update

## Images
    php app/console assets:install


## Update PricePoint
When you set all parameters : 

    php app/console allopass:prices:update


# How to use it 

## Go to the payment page

You need to set the data field for example with an invoice id or a user id

    $this->generateUrl(
        "sinenco_allopass_payment_prepare", array(
            'data' => 'your data'
        )
    )

This link redirects to a page on your server (resource from this bundle) where : 
- The user choose its country
- Then choose the payment method
- Then, he's redirected to an allopass document generated with the Allopass API


## Payment And Event
When the payment is complete, you have to process the payment with callback actions, and redirect your cutomer with the return url

### The return Url

Remember, you set à parameter in sinenco.allopass_payments.return_route
 
When a user pay with allopass, he will be redirected to this page. 
With GET parameters : RECALL, data, code, trxid, transaction_id.
The transaction is not checked with return URL but with callback url so you just have to display the correct page to your customer like the invoice page or a confirmation page. 
 

### Callback Url

This url is secured to process actions. Like add a transaction in an invoice. 

This url create an Transaction and an event is dispatched : AllopassPaymentCoreEvents::onAllopassPaymentCallback. 
The event is a AllopassPaymentCallbackEvent object

The event have the method isFirstTime() to know if the transaction existed before this payment. 
The event have the method getTransaction() to get a Sinenco\AllopassPaymentBundle\Entity\Transaction entity. This entity is stored before the dispatch. 

So you have to create a listener, here is an exemple

#### In services.yml

    services:
        shop.allopass.listener.callback:
            class: Shop\PaymentBundle\Listeners\AllopassCallbackListener
            arguments: 
                entityManager: "@doctrine.orm.entity_manager"
                container: "@service_container"
            tags:
                - { name: kernel.event_listener, event: "sinenco.allopasspayment.callback", method: onCallbackAllopass }

#### in Shop\PaymentBundle\Listeners\AllopassCallbackListener

In my example, i set data with an invoice number. 

    <?php

    namespace Shop\PaymentBundle\Listeners;

    use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
    use Symfony\Component\HttpFoundation\Response;
    use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
    use Sinenco\AllopassPaymentBundle\Events\AllopassPaymentCallbackEvent;
    use Shop\PaymentBundle\Entity\Invoice;

    use Doctrine\ORM\EntityManager;
    use Symfony\Component\DependencyInjection\Container;

    class AllopassCallbackListener {

        private $em;
        private $container;

        public function __construct(EntityManager $entityManager, Container $container) {

            $this->em = $entityManager;
            $this->container = $container;
        }

        public function onCallbackAllopass(AllopassPaymentCallbackEvent $event) {
            $repository = $this->em->getRepository("ShopPaymentBundle:Invoice");
            $transaction = $event->getTransaction();

            if ($event->isFirstTime()) {
                $invoice = $repository->find($transaction->getData());

                if ($invoice != null) {
                    $payout_amount = $transaction->getPayoutAmount();
                    $payout_currency = $transaction->getPayoutCurrency();


                    $invoice->addCredit($payout_amount);
                    $this->em->persist($invoice);
                    $this->em->flush();
                }
            }
        }

    }
