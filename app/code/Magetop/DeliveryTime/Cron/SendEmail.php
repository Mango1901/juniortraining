<?php

namespace Magetop\DeliveryTime\Cron;

use Magetop\DeliveryTime\Helper\Email;
use \Psr\Log\LoggerInterface;

class SendEmail {

    private $helperEmail;

    public function __construct(
        Email $helperEmail
    ) {
        $this->helperEmail = $helperEmail;
    }

    public function execute()
    {
        return $this->helperEmail->sendEmail();
    }

}
