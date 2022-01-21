define(
    [
        'jquery',
        'ko',
        'underscore',
        'uiComponent',
        'Magenest_DeliveryTime/js/model/mpdt-data',
        'Magenest_DeliveryTime/js/model/delivery-information',
        'jquery/ui',
        'jquery/jquery-ui-timepicker-addon'
    ],
    function ($, ko, _, Component, mpDtData, customShipTo) {
        'use strict';

        var cacheKeyDeliveryDate = 'deliveryDate',
            cacheKeyDeliveryTime = 'deliveryTime',
            cacheKeyHouseSecurityCode = 'houseSecurityCode',
            cacheKeyDeliveryComment = 'deliveryComment',
            dateFormat = window.checkoutConfig.mpDtConfig.deliveryDateFormat,
            daysOff = window.checkoutConfig.mpDtConfig.deliveryDaysOff || [],
            leadTime = "",
            maxIntervalTime = "",
            dateOff = [];
        var isEnableDisableSameDayDeliveryAfter = window.checkoutConfig.mpDtConfig.isEnableDisableSameDayDeliveryAfter;


        function prepareSubscribeValue(object, cacheKey) {
            object(mpDtData.getData(cacheKey));
            object.subscribe(function (newValue) {
                mpDtData.setData(cacheKey, newValue);
            });
        }

        function formatDeliveryTime(time) {
            var from = time['from'][0] + 'h' + time['from'][1],
                to = time['to'][0] + 'h' + time['to'][1];
            return from + ' - ' + to;
        }

        return Component.extend({
            defaults: {
                template: 'Magenest_DeliveryTime/container/custom-ship-to'
            },
            deliveryDate: customShipTo().deliveryDate,
            deliveryTime: customShipTo().deliveryTime,
            houseSecurityCode: customShipTo().houseSecurityCode,
            deliveryComment: customShipTo().deliveryComment,
            deliveryTimeOptions: customShipTo().deliveryTimeOptions,
            noticeByAdmin: window.checkoutConfig.mpDtConfig.noticeByAdmin,
            timeDisableSameDayDeliveryAfter: window.checkoutConfig.mpDtConfig.timeDisableSameDayDeliveryAfter,
            isVisible: ko.observable(mpDtData.getData(cacheKeyDeliveryDate)),

            initialize: function () {
                this._super();
                var self = this;

                dateOff = _.pluck(window.checkoutConfig.mpDtConfig.deliveryDateOff, 'date_off');
                leadTime = window.checkoutConfig.mpDtConfig.leadTime;
                maxIntervalTime = window.checkoutConfig.mpDtConfig.maxIntervalTime;
                ko.bindingHandlers.mpdatepicker = {
                    init: function (element) {
                        var options = {
                            minDate: 0,
                            showButtonPanel: false,
                            dateFormat: dateFormat,
                            showOn: 'both',
                            buttonText: '',
                            beforeShowDay: function (date) {
                                function addDaysToDate(date, days){
                                    var res = new Date(date);
                                    res.setDate(res.getDate() + days);
                                    return res;
                                }


                                var today = new Date();
                                var getDaysArray = function (start, end) {
                                    for (var arr = [], dt = new Date(start); dt <= end; dt.setDate(dt.getDate() + 1)) {
                                        arr.push(new Date(dt));
                                    }
                                    return arr;
                                };
                                var dateRangeAvailable = [];
                                var daylist = [];
                                if (isEnableDisableSameDayDeliveryAfter) {
                                    let deliveryDate = (addDaysToDate(today, 1));
                                    daylist = getDaysArray(deliveryDate, deliveryDate);
                                    daylist.map((v) => v.toISOString().slice(0, 10)).join("")
                                    $.each(daylist, function (key, value) {
                                        dateRangeAvailable.push(('0' + value.getDate()).slice(-2) + '/' + (value.getMonth() + 1) + '/' + value.getFullYear());
                                    });
                                } else {
                                    if (leadTime) {
                                        var leadTimeDate = (addDaysToDate(today, leadTime));
                                    }

                                    if (maxIntervalTime) {
                                        var maxIntervalTimeDate = (addDaysToDate(today, maxIntervalTime));
                                    }

                                    daylist = getDaysArray(leadTimeDate, maxIntervalTimeDate);
                                    daylist.map((v) => v.toISOString().slice(0, 10)).join("")
                                    $.each(daylist, function (key, value) {
                                        dateRangeAvailable.push(('0' + value.getDate()).slice(-2) + '/' + (value.getMonth() + 1) + '/' + value.getFullYear());
                                    });
                                }

                                var currentDay = date.getDay();
                                var currentDate = date.getDate();
                                var currentMonth = date.getMonth() + 1;
                                var currentYear = date.getFullYear();
                                var dateToCheck = ('0' + currentDate).slice(-2) + '/' + currentMonth + '/' + currentYear;
                                var isAvailableDay = daysOff.indexOf(currentDay) === -1;
                                var isAvailableDate = $.inArray(dateToCheck, dateOff) === -1;
                                var isAvailableDateRange = $.inArray(dateToCheck, dateRangeAvailable) !== -1;
                                return [isAvailableDay && isAvailableDate && isAvailableDateRange];
                            }
                        };
                        $(element).datepicker(options);
                    }
                };

                $.each(window.checkoutConfig.mpDtConfig.deliveryTime, function (index, item) {
                    self.deliveryTimeOptions.push(formatDeliveryTime(item));
                });

                prepareSubscribeValue(this.deliveryDate, cacheKeyDeliveryDate);
                prepareSubscribeValue(this.deliveryTime, cacheKeyDeliveryTime);
                prepareSubscribeValue(this.houseSecurityCode, cacheKeyHouseSecurityCode);
                prepareSubscribeValue(this.deliveryComment, cacheKeyDeliveryComment);


                this.isVisible = ko.computed(function () {
                    return !!self.deliveryDate();
                });

                return this;
            },

            removeDeliveryDate: function () {
                if (mpDtData.getData(cacheKeyDeliveryDate) && mpDtData.getData(cacheKeyDeliveryDate) != null) {
                    this.deliveryDate('');
                }
            }
        });
    }
);
