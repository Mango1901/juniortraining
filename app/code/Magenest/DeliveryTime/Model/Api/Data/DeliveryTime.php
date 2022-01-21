<?php

namespace Magenest\DeliveryTime\Model\Api\Data;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magenest\DeliveryTime\Api\Data\DeliveryTimeInterface;

/**
 * Class DeliveryTime
 * @package Magenest\DeliveryTime\Model\Api\Data
 */
class DeliveryTime extends AbstractExtensibleModel implements DeliveryTimeInterface
{
    /**
     * {@inheritDoc}
     */
    public function getDeliveryDate()
    {
        return $this->getData('deliveryDate');
    }

    /**
     * {@inheritDoc}
     */
    public function setDeliveryDate($value)
    {
        return $this->setData('deliveryDate', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeliveryTime()
    {
        return $this->getData('deliveryTime');
    }

    /**
     * {@inheritDoc}
     */
    public function setDeliveryTime($value)
    {
        return $this->setData('deliveryTime', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getHouseSecurityCode()
    {
        return $this->getData('houseSecurityCode');
    }

    /**
     * {@inheritDoc}
     */
    public function setHouseSecurityCode($value)
    {
        return $this->setData('houseSecurityCode', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getDeliveryComment()
    {
        return $this->getData('deliveryComment');
    }

    /**
     * {@inheritDoc}
     */
    public function setDeliveryComment($value)
    {
        return $this->setData('deliveryComment', $value);
    }
}
