define([], function () {
    'use strict';

    return function (subject) {
        return subject.extend({
            defaults: {
                detailsTemplate: 'Perspective_CustomCheckout/billing-address/details'
            }
        });
    };
});