define(
    [
        'uiComponent',
        'Magento_Checkout/js/model/payment/renderer-list'
    ],
    function (
        Component,
        rendererList
    ) {
        'use strict';
        rendererList.push(
            {
                type: 'simplepayment',
                component: 'Perspective_SimplePaymentMethod/js/view/payment/method-renderer/simplepayment'
            }
        );
        return Component.extend({});
    }
);