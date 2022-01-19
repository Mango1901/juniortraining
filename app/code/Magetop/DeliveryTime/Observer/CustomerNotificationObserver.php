<?php

namespace Magetop\DeliveryTime\Observer;

use Magento\Framework\Event\ObserverInterface;
use Magetop\DeliveryTime\Helper\Email;

class CustomerNotificationObserver implements ObserverInterface
{
    private $helperEmail;

    public function __construct(
        Email $helperEmail
    ) {
        $this->helperEmail = $helperEmail;
    }

    public function execute(\Magento\Framework\Event\Observer $observer)
    {
        return $this->helperEmail->sendEmail();
    }
}
