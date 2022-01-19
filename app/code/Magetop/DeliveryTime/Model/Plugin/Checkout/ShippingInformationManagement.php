<?php
/**
 * Magetop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magetop.com license that is
 * available through the world-wide-web at this URL:
 * https://www.magetop.com/LICENSE.txt
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 *
 * @category    Magetop
 * @package     Magetop_DeliveryTime
 * @copyright   Copyright (c) Magetop (https://www.magetop.com/)
 * @license     https://www.magetop.com/LICENSE.txt
 */

namespace Magetop\DeliveryTime\Model\Plugin\Checkout;

use DateTime;
use DateTimeZone;
use Magento\Checkout\Api\Data\ShippingInformationInterface;
use Magento\Checkout\Exception;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Quote\Api\CartRepositoryInterface;
use Magetop\DeliveryTime\Helper\Data;
use function PHPUnit\Framework\throwException;

/**
 * Class ShippingInformationManagement
 * @package Magetop\DeliveryTime\Model\Plugin\Checkout
 */
class ShippingInformationManagement
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var Data
     */
    private $mpDtHelper;
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * ShippingInformationManagement constructor.
     *
     * @param CartRepositoryInterface $cartRepository
     * @param Data $mpDtHelper
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        Data $mpDtHelper,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->cartRepository = $cartRepository;
        $this->mpDtHelper     = $mpDtHelper;
        $this->scopeConfig    = $scopeConfig;
    }

    /**
     * @param \Magento\Checkout\Model\ShippingInformationManagement $subject
     * @param int $cartId
     * @param ShippingInformationInterface $addressInformation
     *
     * @return array
     * @throws NoSuchEntityException
     */
    public function beforeSaveAddressInformation(
        \Magento\Checkout\Model\ShippingInformationManagement $subject,
        $cartId,
        ShippingInformationInterface $addressInformation
    ) {
        $extensionAttributes = $addressInformation->getShippingAddress()->getExtensionAttributes();

        if (!$extensionAttributes || !$this->mpDtHelper->isEnabled()) {
            return [$cartId, $addressInformation];
        }

        $isEnableDeliveryTimeForTimeDisableSameDayDeliveryAfter = $this->scopeConfig->getValue(
            "mpdeliverytime/general/is_enable_disable_same_day_delivery_after",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );

        $deliveryTimeForTimeDisableSameDayDeliveryAfter = $this->scopeConfig->getValue(
            "mpdeliverytime/general/time_disable_same_day_delivery_after",
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        $formatDeliveryDate = "";
        $deliveryTimeFormat = "";
        if ($isEnableDeliveryTimeForTimeDisableSameDayDeliveryAfter == 1) {
            $deliveryTimeFormat = str_replace(",", ":", $deliveryTimeForTimeDisableSameDayDeliveryAfter);
            $deliveryDate = (array)new DateTime("tomorrow", new DateTimeZone("Asia/HO_CHI_MINH"));
            $formatDeliveryDate = date("d-m-Y", strtotime($deliveryDate["date"]));
        } else {
            if ($extensionAttributes->getMpDeliveryDate() == null) {

            }
            if ($extensionAttributes->getMpDeliveryTime() == null) {
            }
        }

        $deliveryInformation = [
            'deliveryDate'      => ($extensionAttributes->getMpDeliveryDate()) ? $extensionAttributes->getMpDeliveryDate() : $formatDeliveryDate ,
            'deliveryTime'      => ($extensionAttributes->getMpDeliveryTime()) ? $extensionAttributes->getMpDeliveryTime() : $deliveryTimeFormat ,
            'houseSecurityCode' => $extensionAttributes->getMpHouseSecurityCode(),
            'deliveryComment'   => $extensionAttributes->getMpDeliveryComment()
        ];

        $quote = $this->cartRepository->get($cartId);
        $quote->setData('mp_delivery_information', Data::jsonEncode($deliveryInformation));

        return [$cartId, $addressInformation];
    }
}
