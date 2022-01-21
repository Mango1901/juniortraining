<?php

namespace Magenest\DeliveryTime\Model\Api;

use Magento\Quote\Api\CartRepositoryInterface;
use Magenest\DeliveryTime\Api\Data\DeliveryTimeInterfaceFactory;
use Magenest\DeliveryTime\Api\DeliveryTimeManagementInterface;
use Magenest\DeliveryTime\Helper\Data;
use Magenest\DeliveryTime\Model\Api\Data\DeliveryTime;

/**
 * Class DeliveryTimeManagement
 * @package Magenest\DeliveryTime\Model\Api
 */
class DeliveryTimeManagement implements DeliveryTimeManagementInterface
{
    /**
     * @var CartRepositoryInterface
     */
    private $cartRepository;

    /**
     * @var DeliveryTimeInterfaceFactory
     */
    private $deliveryTimeFactory;

    /**
     * DeliveryTimeManagement constructor.
     *
     * @param CartRepositoryInterface $cartRepository
     * @param DeliveryTimeInterfaceFactory $deliveryTimeFactory
     */
    public function __construct(
        CartRepositoryInterface $cartRepository,
        DeliveryTimeInterfaceFactory $deliveryTimeFactory
    ) {
        $this->cartRepository      = $cartRepository;
        $this->deliveryTimeFactory = $deliveryTimeFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function get($cartId)
    {
        $quote = $this->cartRepository->get($cartId);

        $mpDtData = Data::jsonDecode($quote->getData('mp_delivery_information'));

        /** @var DeliveryTime $deliveryTime */
        $deliveryTime = $this->deliveryTimeFactory->create();

        return $deliveryTime->setData($mpDtData);
    }
}
