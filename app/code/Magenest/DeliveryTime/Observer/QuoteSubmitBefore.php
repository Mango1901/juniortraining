<?php

namespace Magenest\DeliveryTime\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Quote\Model\Quote;
use Magento\Sales\Api\Data\OrderInterface;

/**
 * Class QuoteSubmitBefore
 * @package Magenest\DeliveryTime\Observer
 */
class QuoteSubmitBefore implements ObserverInterface
{
    /**
     * @param Observer $observer
     */
    public function execute(Observer $observer)
    {
        /** @var Quote $quote */
        $quote = $observer->getEvent()->getQuote();
        /** @var OrderInterface $order */
        $order = $observer->getEvent()->getOrder();

        if ($mpDtData = $quote->getData('mp_delivery_information')) {
            $order->setData('mp_delivery_information', $mpDtData);
        }
    }
}
