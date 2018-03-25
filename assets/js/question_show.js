$(function() {
    APP.question_show.init();
});

var APP = APP || {};

APP.question_show = {
    option_radio: $('.option_radio'),

    init: function() {
        this.checkAnswer();
    },

    checkAnswer: function() {
        var self = this;
        this.option_radio.click(function() {
            self.displayAnswer($(this));
        });
    },

    displayAnswer: function(handle) {
        this.option_radio.each(function(index) {
            if($(this).val() == $('#correct_answer').val()) {
                $(this).parent().find('.answer_icon').addClass('fi-check correct');
            } else {
                $(this).parent().find('.answer_icon').addClass('fi-x wrong');
            }
        });
        $('#answer').val(handle.val());
        this.option_radio.prop('disabled', true);
    },

    clickAnswer: function(val) {
        $('.option_radio[value='+val+']').prop('checked', true);
        this.displayAnswer($(this));
        console.log('aaa');
    },
};
