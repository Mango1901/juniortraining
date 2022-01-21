define([
    'jquery',
    'mage/utils/wrapper',
    'Magento_Checkout/js/model/quote',
    'Magenest_DeliveryTime/js/model/delivery-information'
], function ($, wrapper, quote, deliveryInformation) {
    'use strict';

    return function (setShippingInformationAction) {
        if (!window.checkoutConfig || !window.checkoutConfig.mpDtConfig) {
            return setShippingInformationAction;
        }

        return wrapper.wrap(setShippingInformationAction, function (originalAction) {
            var shippingAddress = quote.shippingAddress();

            if (!shippingAddress.hasOwnProperty('extension_attributes')) {
                shippingAddress.extension_attributes = {};
            }
            var deliveryTime = "";
            var houseSecurityCode = "";
            var deliveryDate = deliveryInformation().deliveryDate();
            if (window.checkoutConfig.mpDtConfig.isEnabledDeliveryTime) {
                deliveryTime = deliveryInformation().deliveryTime()
            } else{
                deliveryTime = null;
            }
            if (window.checkoutConfig.mpDtConfig.isEnabledHouseSecurityCode) {
                houseSecurityCode = deliveryInformation().houseSecurityCode()
            } else{
                houseSecurityCode = null;
            }
            if (window.checkoutConfig.mpDtConfig.isEnabledDeliveryComment) {
                var deliveryComment = deliveryInformation().deliveryComment()
            }
            var checkDeliveryData = {
                mp_delivery_date: deliveryDate,
                mp_delivery_time: deliveryTime,
                mp_house_security_code: houseSecurityCode
            };
            var deliveryData = {
                mp_delivery_date: deliveryInformation().deliveryDate(),
                mp_delivery_time: deliveryInformation().deliveryTime(),
                mp_house_security_code: deliveryInformation().houseSecurityCode(),
                mp_delivery_comment: deliveryInformation().deliveryComment()
            };

            for (const [key, value] of Object.entries(checkDeliveryData)) {
                if (value == "" || typeof value == "undefined") {
                    $(".message.error." + key).css("display", "inline-block");
                    $(".message.error." + key).html(key + "is required");
                } else {
                    $(".message.error." + key).css("display", "none");
                }
            }

            if (deliveryComment.length > 500) {
                $(".message.error.mp_delivery_comment").css("display", "inline-block");
                $(".message.error.mp_delivery_comment").html("the delivery comment is only allow max 500 characters");
                return false;
            } else {
                $(".message.error.mp_delivery_comment").css("display", "none");
            }
            for (const [key, value] of Object.entries(checkDeliveryData)) {
                if ($(".message.error." + key).is(':visible')) {
                    return false;
                }
            }


            shippingAddress.extension_attributes = $.extend(
                shippingAddress.extension_attributes,
                deliveryData
            );

            return originalAction();
        });
    };
});
