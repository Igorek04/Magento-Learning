// This plugin depends on jQuery, so we want to make sure jQuery is loaded first.
(function ($) {
    $.log = function (message) {
        console.log(message);
    };
})(jQuery);