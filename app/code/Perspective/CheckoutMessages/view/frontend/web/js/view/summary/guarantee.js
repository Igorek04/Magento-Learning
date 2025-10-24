define(["uiComponent"], function (Component) {
    'use strict'

    return Component.extend({
        initialize: function(){
            this._super();
            console.log('guarantee initialized test');
        },

        showMessage: function(){
            return this.subtotal > 100;
        }
    });
});