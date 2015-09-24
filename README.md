# AllopassPayment

(Use sinenco/allopassapi package)


# Installation
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


## Images
    php app/console assets:install


## Update PricePoint
When you set all parameters : 

    php app/console allopass:prices:update


## Payment And Event
When a user pay, an event is dispatched : AllopassPaymentCoreEvents::onAllopassPaymentCallback. 
The event is a AllopassPaymentCallbackEvent object

The event have the method isFirstTime() to know if the transaction existed before this payment. 

