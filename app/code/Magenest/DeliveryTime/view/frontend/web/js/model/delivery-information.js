define(
    [
        'ko',
        'uiComponent'
    ],
    function (ko, Component) {
        'use strict';

        return Component.extend({
            deliveryDate: ko.observable(),
            deliveryTime: ko.observable(),
            houseSecurityCode: ko.observable(),
            deliveryComment: ko.observable(),
            deliveryTimeOptions: ko.observableArray([]),
            noticeByAdmin: ko.observable(),
            timeDisableSameDayDeliveryAfter: ko.observable()
        });
    }
);
