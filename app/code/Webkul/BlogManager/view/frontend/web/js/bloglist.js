define([
    "jquery",
    'Magento_Ui/js/modal/confirm',
    'Magento_Ui/js/modal/alert',
    'mage/translate'
], function ($, confirmation, alert, $t) {
    $('.blog-list-table .blog-list-table-action.blog-list-table-action-delete a').on('click', function (e) {
        var self = this;
        e.preventDefault();
        confirmation({
            title: $t('Delete?'),
            content: $t('Are you sure you want to delete this blog?'),
            actions: {
                confirm: function () {
                    var url = $(self).attr('href');
                    $.ajax({
                        type: "GET",
                        dataType: "json",
                        url: url,
                        beforeSend: function () {
                            $('body').trigger("processStart");
                        },
                        success: function (response) {
                            $('body').trigger("processStop");
                            $(self).closest('.blog-list-table-row').remove();
                            alert({
                                content: response.message
                            });
                        },
                        error: function () {
                            $('body').trigger("processStop");
                            alert({
                                content: $t('Something went wrong.')
                            });
                        }
                    });
                },
                cancel: function () {
                }
            }
        });
    });
});
