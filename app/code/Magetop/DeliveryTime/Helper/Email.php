<?php

namespace Magetop\DeliveryTime\Helper;

use Magento\Framework\App\Helper\Context;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Translate\Inline\StateInterface;

class Email extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected $inlineTranslation;
    protected $escaper;
    protected $transportBuilder;
    protected $logger;
    protected $orderCollection;
    protected $scopeConfig;

    public function __construct(
        Context $context,
        StateInterface $inlineTranslation,
        Escaper $escaper,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $orderCollectionFactory,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        TransportBuilder $transportBuilder
    )
    {
        parent::__construct($context);
        $this->inlineTranslation = $inlineTranslation;
        $this->escaper = $escaper;
        $this->transportBuilder = $transportBuilder;
        $this->logger = $context->getLogger();
        $this->orderCollection = $orderCollectionFactory;
        $this->scopeConfig = $scopeConfig;
    }

    public function sendEmail()
    {
        try {
            $getOrders = $this->orderCollection->create();
            foreach ($getOrders as $getOrder) {
                if ($getOrder->getData("mp_delivery_information")) {
                    //format d-m-Y H:i
                    $jsonDeliveryInfo = json_decode($getOrder->getData("mp_delivery_information"), true);
                    $test1 = (array)new dateTime('now', new DateTimeZone("Asia/Ho_Chi_Minh"));
                    $deliveryDate = $jsonDeliveryInfo["deliveryDate"];
                    $deliveryTime = $jsonDeliveryInfo["deliveryTime"];
                    $arrayTimes = explode(" - ", $deliveryTime);
                    $array = [];
                    foreach ($arrayTimes as $arrayTime) {
                        $array[] = str_replace("h", ":", $arrayTime);
                    }
                    $compareDeliveryDate = date('d-m-Y H:i', strtotime($deliveryDate . " " . "$array[1]"));
                    $compareTest = date("d-m-Y H:i", strtotime($test1["date"]));
                    $hourDiff = round((strtotime($compareDeliveryDate) - strtotime($compareTest)) / 3600, 1);
                    if ($hourDiff > 0 && $hourDiff < 1) {
                        $this->inlineTranslation->suspend();
                        $sender = [
                            'name' => $this->escaper->escapeHtml('Test'),
                            'email' => $this->escaper->escapeHtml('hieu.tuhai2001@gmail.com'),
                        ];
                        $transport = $this->transportBuilder
                            ->setTemplateIdentifier('email_demo_template')
                            ->setTemplateOptions(
                                [
                                    'area' => \Magento\Framework\App\Area::AREA_FRONTEND,
                                    'store' => \Magento\Store\Model\Store::DEFAULT_STORE_ID,
                                ]
                            )
                            ->setTemplateVars([
                                'templateVar' => 'My Topic',
                            ])
                            ->setFrom($sender)
                            ->addTo($getOrder->getEmail())
                            ->getTransport();
                        $transport->sendMessage();
                        $this->inlineTranslation->resume();
                    }
                }
            }
        } catch (\Exception $e) {
            $this->logger->debug($e->getMessage());
        }
    }
}
