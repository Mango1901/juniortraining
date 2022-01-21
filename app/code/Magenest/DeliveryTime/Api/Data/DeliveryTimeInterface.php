<?php

namespace Magenest\DeliveryTime\Api\Data;

/**
 * Interface DeliveryTime
 * @api
 */
interface DeliveryTimeInterface
{
    /**
     * Constants defined for keys of array, makes typos less likely
     */
    const DELIVERY_DATE       = 'deliveryDate';
    const DELIVERY_TIME       = 'deliveryTime';
    const HOUSE_SECURITY_CODE = 'houseSecurityCode';
    const DELIVERY_COMMENT    = 'deliveryComment';

    /**
     * @return string
     */
    public function getDeliveryDate();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDeliveryDate($value);

    /**
     * @return string
     */
    public function getDeliveryTime();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDeliveryTime($value);

    /**
     * @return string
     */
    public function getHouseSecurityCode();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setHouseSecurityCode($value);

    /**
     * @return string
     */
    public function getDeliveryComment();

    /**
     * @param string $value
     *
     * @return $this
     */
    public function setDeliveryComment($value);
}
