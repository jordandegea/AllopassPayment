# AllopassPayment

(Use sinenco/allopassapi package)


# Installation
add in composer require : 
   "sinenco/AllopassPayment" : "dev-master"

# Configuration

## Parameters for AllopassPayment
    sinenco.allopass_payments.return_route: "Your controller page for return"

When a user pay with allopass, he will be redirected to this page. 
With GET parameters : RECALL, data, code, trxid, transaction_id


## Parameters for AllopassAPI
### Required 
    allopassAPI.api_key: "your api key"
    allopassAPI.secret_key: "your secret key"

    allopassAPI.default_hash: "sha1"
    allopassAPI.default_format: "xml"
    allopassAPI.network_timeout: "30"
    allopassAPI.network_protocol: "http"
    allopassAPI.network_port: "80"
    allopassAPI.host: "api.allopass.com"


## Parameters for AllopassPayment

    allopass_payment.site_id: ""
    allopass_payment.product_name: ""


## Payment

When a user pay, an event is dispatched : AllopassPaymentCoreEvents::onAllopassPaymentCallback. 
The event is a AllopassPaymentCallbackEvent object



## Service to add

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