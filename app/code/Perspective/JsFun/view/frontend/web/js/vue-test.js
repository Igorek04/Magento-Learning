define(['vue', 'jquery', 'Perspective_JsFun/js/jquery-log'], function (Vue, $) {
    'use strict';
    $.log('Testing output to the console');
    return function (config) {
        return new Vue({
            el: '#vue-test',
            data: {
                message: config.message
            }
        });
    };
});