<?php

namespace Magenest\DeliveryTime\Model;

use Magento\Checkout\Model\ConfigProviderInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magenest\DeliveryTime\Helper\Data as MpDtHelper;
use Zend_Serializer_Exception;

/**
 * Class DefaultConfigProvider
 * @package Magenest\DeliveryTime\Model
 */
class DefaultConfigProvider implements ConfigProviderInterface
{
    /**
     * @var MpDtHelper
     */
    protected $mpDtHelper;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * DefaultConfigProvider constructor.
     *
     * @param MpDtHelper $mpDtHelper
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        MpDtHelper $mpDtHelper,
        StoreManagerInterface $storeManager
    ) {
        $this->mpDtHelper   = $mpDtHelper;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig()
    {
        if (!$this->mpDtHelper->isEnabled()) {
            return [];
        }
        return ['mpDtConfig' => $this->getMpDtConfig()];
    }

    /**
     * @return array
     * @throws Zend_Serializer_Exception
     */
    private function getMpDtConfig()
    {
        return [
            'isEnabledDeliveryTime'      => $this->mpDtHelper->isEnabledDeliveryTime(),
            'isEnabledHouseSecurityCode' => $this->mpDtHelper->isEnabledHouseSecurityCode(),
            'isEnabledDeliveryComment'   => $this->mpDtHelper->isEnabledDeliveryComment(),
            'deliveryDateFormat'         => $this->mpDtHelper->getDateFormat(),
            'deliveryDaysOff'            => $this->mpDtHelper->getDaysOff(),
            'deliveryDateOff'            => $this->mpDtHelper->getDateOff(),
            'deliveryTime'               => $this->mpDtHelper->getDeliveryTIme(),
            'leadTime'                   => $this->mpDtHelper->getLeadTime(),
            'maxIntervalTime'            => $this->mpDtHelper->getMaxIntervalTime(),
            'isEnableDisableSameDayDeliveryAfter' => $this->mpDtHelper->isEnableDisableSameDayDeliveryAfter(),
            'isEnableNoticeByAdmin'              => $this->mpDtHelper->isEnableNoticeByAdmin(),
            'noticeByAdmin'              => $this->mpDtHelper->getNoticeByAdmin(),
            'timeDisableSameDayDeliveryAfter'=>str_replace(',', ':', $this->mpDtHelper->getTimeDisableSameDayDeliveryAfter())
        ];
    }
}
