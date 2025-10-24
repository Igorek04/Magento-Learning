var config = {
    map: {
        '*': {
            'Magento_Checkout/template/sidebar': 'Perspective_CheckoutMessages/template/sidebar'
        }
    },
    config: {
        mixins: {
            'Magento_Checkout/js/view/summary/cart-items': {
                'Perspective_CheckoutMessages/js/view/summary/cart-items-mixin': true
            }
        }
    }
};