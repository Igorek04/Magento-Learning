define(['jquery'], function ($) {
    'use strict'
    return function (className, duration) {
        /*
        * Since parameter defaults only exist in ES6 and beyond, to make code
        * with the highest level of compatibility, you can define defaults with
        * the "||" (OR) symbol to define value fallbacks.
        */
        $(className).hide().fadeIn(duration || 2000);
    };
})