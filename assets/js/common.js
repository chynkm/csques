$(function() {
    APP.common.init();
});

var APP = APP || {};

APP.common = {
    body: $('body'),

    init: function() {
        this.disableRightClick();
        this.errorBlock();
    },

    disableRightClick: function() {
        this.body.bind('cut copy paste', function (e) {
            e.preventDefault();
            return false;
        });
    },

    errorBlock: function () {
        // Highlight error fields if error is present
        if($('.error_block').length) {
            $('.error_block').closest('.form_group').find('input, textarea, select').addClass('has_error');
        }
    },
};
