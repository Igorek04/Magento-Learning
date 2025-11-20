let config = {
    deps: [
        'Perspective_CustomCheckout/js/mask-telephone-inputs'
    ],
    config: {
        mixins: {
            'Magento_Checkout/js/action/set-shipping-information': {
                'Perspective_CustomCheckout/js/action/set-shipping-information-mixin': true
            },
            'Magento_Checkout/js/view/billing-address': {
                'Perspective_CustomCheckout/js/view/billing-address-mixin': true
            }
        }
    }
};