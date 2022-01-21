<?php
namespace Magenest\DeliveryTime\Block\Adminhtml\Plugin;

use Magento\Sales\Block\Adminhtml\Order\View\Tab\Info;

/**
 * Class OrderViewTabInfo
 * @package Magenest\DeliveryTime\Block\Adminhtml\Plugin
 */
class OrderViewTabInfo
{
    /**
     * @param Info $subject
     * @param $result
     *
     * @return string
     */
    public function afterGetGiftOptionsHtml(Info $subject, $result)
    {
        $result .= $subject->getChildHtml('mp_delivery_information');

        return $result;
    }
}
