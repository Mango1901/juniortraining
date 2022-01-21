<?php

namespace Magenest\DeliveryTime\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface;

/**
 * Interface DeliveryTimeManagementInterface
 *
 * @package Magenest\DeliveryTime\Api
 */
interface DeliveryTimeManagementInterface
{
    /**
     * @param string $cartId
     *
     * @return DeliveryTimeInterface
     * @throws NoSuchEntityException
     */
    public function get($cartId);
}
