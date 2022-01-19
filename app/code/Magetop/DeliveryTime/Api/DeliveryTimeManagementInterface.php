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
 * @package     Magetop_GiftCard
 * @copyright   Copyright (c) Magetop (https://www.magetop.com/)
 * @license     https://www.magetop.com/LICENSE.txt
 */

namespace Magetop\DeliveryTime\Api;

use Magento\Framework\Exception\NoSuchEntityException;
use Magetop\DeliveryTime\Api\Data\DeliveryTimeInterface;

/**
 * Interface DeliveryTimeManagementInterface
 *
 * @package Magetop\DeliveryTime\Api
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
