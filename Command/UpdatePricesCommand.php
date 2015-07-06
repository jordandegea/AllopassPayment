<?php

namespace Sinenco\AllopassPaymentBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Sinenco\AllopassAPIBundle\API\AllopassAPI;
use Sinenco\AllopassPaymentBundle\Entity\PricePoint;
use Sinenco\AllopassAPIBundle\Model\AllopassMarket;

class UpdatePricesCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('allopass:prices:update')
                ->setDescription('Update Allopass prices for the product')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $this->getContainer()->get("sinenco_allopass_api.init");
        //$allopass = AllopassApiConf::getInstance();


        $em = $this
                ->getContainer()
                ->get('doctrine')
                ->getManager();

        $pricepoints = $em
                ->getRepository('SinencoAllopassPaymentBundle:PricePoint')
                ->findAll();

        foreach ($pricepoints as $pricepoint) {
            $em->remove($pricepoint);
        }

        $em->flush();

        $api = new AllopassAPI();

        $response = $api->getOnetimePricing(array('site_id' => $this->getContainer()->getParameter("allopass_payment.site_id")));


        $i = 1;

        foreach ($response->getMarkets() as $market) {

            foreach ($market->getPricepoints() as $AllopassPricePoint) {

                $PricePoint = new PricePoint();

                $PricePoint->setId($i++);
                $PricePoint->setPriceId($AllopassPricePoint->getId());
                $PricePoint->setType($AllopassPricePoint->getType());
                $PricePoint->setCategory($AllopassPricePoint->getCategory());
                $PricePoint->setCountry($AllopassPricePoint->getCountryCode());

                $PricePoint->setPriceAmount($AllopassPricePoint->getPrice()->getAmount());
                $PricePoint->setPriceCurrency($AllopassPricePoint->getPrice()->getCurrency());

                $PricePoint->setPayoutAmount($AllopassPricePoint->getPayout()->getAmount());
                $PricePoint->setPayoutCurrency($AllopassPricePoint->getPayout()->getCurrency());

                $em->persist($PricePoint);
            }
        }
        $em->flush();

        $output->writeln("PricePoint Updated");
    }

}
