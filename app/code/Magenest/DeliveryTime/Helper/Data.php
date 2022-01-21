<?php

namespace Magenest\DeliveryTime\Helper;

use Magenest\DeliveryTime\Model\System\Config\Source\DeliveryTime;
use Zend_Serializer_Exception;

/**
 * Class Data
 * @package Magenest\DeliveryTime\Helper
 */
class Data extends AbstractData
{
    const CONFIG_MODULE_PATH = 'mpdeliverytime';

    /**
     * @param null $store
     *
     * @return bool
     */
    public function isDisabled($store = null)
    {
        return !$this->isEnabled($store);
    }

    /**
     * Delivery Time
     *
     * @param null $store
     *
     * @return bool
     */
    public function isEnabledDeliveryTime($store = null)
    {
        return (bool) $this->getConfigGeneral('is_enabled_delivery_time', $store);
    }

    /**
     * House Security Code
     *
     * @param null $store
     *
     * @return bool
     */
    public function isEnabledHouseSecurityCode($store = null)
    {
        return (bool) $this->getConfigGeneral('is_enabled_house_security_code', $store);
    }

    /**
     * Delivery Comment
     *
     * @param null $store
     *
     * @return bool
     */
    public function isEnabledDeliveryComment($store = null)
    {
        return (bool) $this->getConfigGeneral('is_enabled_delivery_comment', $store);
    }

    /**
     * Date Format
     *
     * @param null $store
     *
     * @return string
     */
    public function getDateFormat($store = null)
    {
        return $this->getConfigGeneral('date_format', $store) ?: DeliveryTime::DAY_MONTH_YEAR_SLASH;
    }

    /**
     * Days Off
     *
     * @param null $store
     *
     * @return bool|mixed
     */
    public function getDaysOff($store = null)
    {
        return $this->getConfigGeneral('days_off', $store);
    }

    /**
     * Date Off
     *
     * @param null $store
     *
     * @return mixed
     * @throws Zend_Serializer_Exception
     */
    public function getDateOff($store = null)
    {
        return $this->unserialize($this->getConfigGeneral('date_off', $store));
    }

    /**
     * Delivery Time
     *
     * @param null $store
     *
     * @return mixed
     * @throws Zend_Serializer_Exception
     */
    public function getDeliveryTIme($store = null)
    {
        return $this->unserialize($this->getConfigGeneral('delivery_time', $store));
    }

    public function getLeadTime($store = null)
    {
        return $this->unserialize($this->getConfigGeneral('lead_time', $store));
    }

    public function getMaxIntervalTime($store = null)
    {
        return $this->unserialize($this->getConfigGeneral('maximal_delivery_interval', $store));
    }

    public function isEnableDisableSameDayDeliveryAfter($store = null)
    {
        return (bool)$this->unserialize($this->getConfigGeneral('is_enable_disable_same_day_delivery_after', $store));
    }
    public function isEnableNoticeByAdmin($store = null)
    {
        return (bool) $this->unserialize($this->getConfigGeneral('is_enable_notice_by_admin', $store));
    }

    public function getNoticeByAdmin($store = null)
    {
        return $this->getConfigGeneral('notice_by_admin', $store);
    }

    public function getTimeDisableSameDayDeliveryAfter($store = null)
    {
        return $this->getConfigGeneral('time_disable_same_day_delivery_after', $store);
    }
}
