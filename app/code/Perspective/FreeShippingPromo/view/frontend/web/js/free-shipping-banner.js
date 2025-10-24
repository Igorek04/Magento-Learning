define([
    'uiComponent',
    'ko',
    'Magento_Customer/js/customer-data',
    'underscore'
], function (
    Component,
    ko,
    customerData,
    _
) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Perspective_FreeShippingPromo/free-shipping-banner',
            subtotal: 0.00,
            freeShippingThreshold: 100,
            tracks: {
                subtotal: true
            }
        },

        initialize: function () {
            this._super();

            var cart = customerData.get('cart');
            var self = this;

            console.log(cart());

            //init customer data
            customerData.getInitCustomerData().done(function () {
                //if cart not empty and subtotal defined
                if (!_.isEmpty(cart()) &&
                    !_.isUndefined(cart().subtotalAmount)) {
                    //subtotal = value-from-cart
                    self.subtotal = parseFloat(cart().subtotalAmount);
                }
            });

            cart.subscribe(function (cart) {
                if (!_.isEmpty(cart) && !_.isUndefined(cart.subtotalAmount)) {
                    self.subtotal = parseFloat(cart.subtotalAmount);
                    console.log('cart updated');
                }
            });

            //
            self.message = ko.computed(function () {
                // if subtotal = 0 or undefined --> message = messageDefault
                if (self.subtotal === 0 || _.isUndefined(self.subtotal)) {
                    return self.messageDefault.replace('{{freeShippingThreshold}}', self.freeShippingThreshold);
                }

                // if 0 < subtotal < 100  --> message = messageItemsInCart
                if (self.subtotal > 0 && self.subtotal < 100) {
                    var subtotalRemaining = self.freeShippingThreshold - self.subtotal;
                    var formattedSubtotalRemaining = self.formatCurrency(subtotalRemaining);
                    
                    return self.messageItemsInCart.replace('$XX.XX', formattedSubtotalRemaining);
                }

                // if subtotal > 100  --> message = messageFreeShipping
                if (self.subtotal >= 100) {
                    return self.messageFreeShipping;
                }
            });
        },

        formatCurrency: function (value) {
            return '$' + value.toFixed(2);
        }
    });
});


/*
define([
    'uiComponent',
    'ko'
], function (
    Component,
    ko
) {
    'use strict';
    return Component.extend({
        defaults: {
            template: 'Perspective_FreeShippingPromo/free-shipping-banner',
            subtotal: ko.observable(33.00),
            tracks: {
                subtotal: true
            }
        },

        initialize: function () {
            this._super();
            var self = this;

            window.setTimeout(function() {
                self.subtotal(35.00)
            }, 15000);

            console.log(this.message);
        },

        formatCurrency: function (value) {
            return '$' + value().toFixed(2);
        }
    });
});
*/