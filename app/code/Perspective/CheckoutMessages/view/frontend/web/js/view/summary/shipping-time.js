define(["uiComponent"], function (Component) {
    'use strict'
    return Component.extend({
        initialize: function(){
            this._super();
            console.log('shippingTime initialized test');
        },

        defaults: {
            listens: {
                '${ $.shippingAddressProvider }.country_id': 'countryId',
                '${ $.shippingAddressProvider }.region_id': 'handleRegionChange'
            },
            tracks: {
                countryId: true
            }
        },

        showMessage: function () {
            return this.countryId === 'US';
        },
        
        handleRegionChange: function(newRegionId) {
            console.log('New Region ID: ' + newRegionId);
        }
    })
});