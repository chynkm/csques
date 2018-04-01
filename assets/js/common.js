$(function() {
    APP.common.init();
});

var APP = APP || {};

APP.common = {
    body: $('body'),

    init: function() {
        this.disableRightClick();
    },

    disableRightClick: function() {
        this.body.bind('cut copy paste', function (e) {
            e.preventDefault();
            return false;
        });

        this.body.on('contextmenu', function(e){
            return false;
        });
    },
};
