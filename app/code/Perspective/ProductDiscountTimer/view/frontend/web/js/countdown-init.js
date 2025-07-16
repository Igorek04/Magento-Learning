require(['jquery', 'countdown'], function ($) {
    $(document).ready(function () {
        var $countdown = $('#countdown');

        var endDate = new Date($countdown.data('end'));

        $countdown.countdown(endDate, function (event) {
            var format = '%D days %H:%M:%S';
            $countdown.html(event.strftime(format));
        });
    });
});
