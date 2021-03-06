<?php

namespace Magenest\DeliveryTime\Block\Order\View;

use Magento\Framework\DataObject;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magenest\DeliveryTime\Helper\Data as MpDtHelper;

/**
 * Class Comment
 * @package Magenest\DeliveryTime\Block\Order\View
 */
class DeliveryInformation extends Template
{
    /**
     * @type Registry|null
     */
    protected $registry = null;

    /**
     * @var MpDtHelper
     */
    protected $mpDtHelper;

    /**
     * @param Context $context
     * @param Registry $registry
     * @param MpDtHelper $mpDtHelper
     * @param array $data
     */
    public function __construct(
        Context $context,
        Registry $registry,
        MpDtHelper $mpDtHelper,
        array $data = []
    ) {
        $this->registry   = $registry;
        $this->mpDtHelper = $mpDtHelper;

        parent::__construct($context, $data);
    }

    /**
     * Get delivery information
     *
     * @return DataObject
     */
    public function getDeliveryInformation()
    {
        $result = [];

        if ($order = $this->getOrder()) {
            $deliveryInformation = $order->getMpDeliveryInformation();

            if (is_array(json_decode($deliveryInformation, true))) {
                $result = json_decode($deliveryInformation, true);
            } else {
                $values = explode(' ', $deliveryInformation);
                if (sizeof($values) > 1) {
                    $result['deliveryDate'] = $values[0];
                    $result['deliveryTime'] = $values[1];
                }

                $result['houseSecurityCode'] = $order->getOscOrderHouseSecurityCode();
            }
        }

        return new DataObject($result);
    }

    /**
     * Get current order
     *
     * @return mixed
     */
    public function getOrder()
    {
        return $this->registry->registry('current_order');
    }
}
