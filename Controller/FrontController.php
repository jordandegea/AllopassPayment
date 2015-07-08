<?php

namespace Sinenco\AllopassPaymentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use AllopassApiConf ;
use Sinenco\AllopassAPIBundle\Model\AllopassApiConf;
use Sinenco\AllopassAPIBundle\API\AllopassAPI;
use Sinenco\AllopassPaymentBundle\Entity\Transaction;
use Sinenco\AllopassPaymentBundle\Events\AllopassPaymentCallbackEvent;
use Sinenco\AllopassPaymentBundle\Events\AllopassPaymentCoreEvents;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends Controller {

    public function prepareAction($data) {

        $em = $this->getDoctrine()->getManager();

        $repository = $em->getRepository("SinencoAllopassPaymentBundle:PricePoint");

        $pricePoints = $repository->findAll();

        $countries = [];

        foreach ($pricePoints as $pricepoint) {
            $country = $pricepoint->getCountry();
            $type = $pricepoint->getType();
            $countries[$country][$type][] = $pricepoint;
        }

        return $this->render('SinencoAllopassPaymentBundle:Pay:prepare.html.twig', array(
                    'countries' => $countries,
                    'data' => $data
        ));
    }

    public function payAction($id, $data) {

        $this->get("sinenco_allopass_api.init");
        $api = new AllopassAPI();
        $response = $api->prepareTransaction(
                array(
                    'site_id' => $this->container->getParameter("allopass_payment.site_id"),
                    'pricepoint_id' => $id,
                    'product_name' => $this->container->getParameter("allopass_payment.product_name"),
                    'forward_url' => $this->generateUrl("sinenco_allopass_payment_return", null, true ),
                    'notification_url' => $this->generateUrl("sinenco_allopass_payment_callback", null, true),
                    'data' => $data
                //reference_currency
                //error_url
                //country
                )
        );

        return $this->redirect($response->getBuyUrl());
    }

    public function callbackAction() {

        $transaction_id = $_GET['transaction_id'];

        $this->get("sinenco_allopass_api.init");

        $api = new AllopassAPI();
        $response = $api->getTransaction($transaction_id);

        $AllopassTransaction = $response;

        if ($AllopassTransaction->getStatusDescription() == "success") {

            $em = $this->getDoctrine()->getManager();

            $repository = $em->getRepository("SinencoAllopassPaymentBundle:Transaction");

            $transaction = $repository->findOneBy(array(
                "transaction_id" => $transaction_id
            ));
            if ($transaction == NULL) {
                $transaction = new Transaction();

                $transaction->setTransactionId($AllopassTransaction->getTransactionId());

                $transaction->setPriceAmount($AllopassTransaction->getPrice()->getAmount());
                $transaction->setPriceCurrency($AllopassTransaction->getPrice()->getCurrency());

                $datetime = new \DateTime;
                $datetime->setTimestamp($AllopassTransaction->getCreationDate()->getTimestamp());
                $transaction->setCreationDate($datetime);

                $transaction->setPayoutAmount($_GET["payout_amount"]);
                $transaction->setPayoutCurrency($_GET["payout_currency"]);
                $transaction->setData($_GET['data']);

                $em->persist($transaction);
                $em->flush();

                $first_time = true;
            } else {
                $first_time = false;
            }

            $event = new AllopassPaymentCallbackEvent($transaction, $first_time);

            $this
                    ->container
                    ->get('event_dispatcher')
                    ->dispatch(AllopassPaymentCoreEvents::onAllopassPaymentCallback, $event)
            ;
        }

        return new Response();
    }

    public function returnAction() {
        if ($this->container->getParameter("sinenco.allopass_payments.return_route") == "") {
            $response = new Response();
            $response->setContent("You need to create your own return Page");
            return $response;
        }
        return new RedirectResponse(
                $this->generateUrl(
                        $this->container->getParameter("sinenco.allopass_payments.return_route")
                ) . http_build_query($_GET), 307
        );
    }

}
