define([
    'Magento_Checkout/js/view/payment/default',
    'jquery',
    'mage/validation'
], function (Component, $) {
    'use strict';

    return Component.extend({
        defaults: {
            template: 'Perspective_CustomPayment/payment/custompayment-form',
            assistantId: ''
        },

        /** @inheritdoc */
        initObservable: function () {
            this._super()
                .observe('assistantId');

            return this;
        },

        /**
         * @return {Object}
         */
        getData: function () {
            return {
                method: this.item.method,
                'additional_data': {
                    'assistant_id': this.assistantId()
                }
            };
        },

        /**
         * @return {jQuery}
         */
        validate: function () {
            var form = 'form[data-role=custompayment-form]';

            return $(form).validation() && $(form).validation('isValid');
        }
    });
});