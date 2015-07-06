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
### Optional : 
    allopassAPI.default_hash: "sha1"
    allopassAPI.default_format: "xml"
    allopassAPI.network_timeout: "30"
    allopassAPI.network_protocol: "http"
    allopassAPI.network_port: "80"
    allopassAPI.host: "api.allopass.com"

## Payment

When a user pay, an event is dispatched : AllopassPaymentCoreEvents::onAllopassPaymentCallback. 
The event is a AllopassPaymentCallbackEvent object