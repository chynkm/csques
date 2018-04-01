$(function() {
    APP.question_show.init();
});

var APP = APP || {};

APP.question_show = {
    option_radio: $('.option_radio'),
    countdown_timer: $('#countdownExample .values'),

    init: function() {
        this.checkAnswer();
        this.manuallyEndPaper();
    },

    checkAnswer: function() {
        var self = this;
        this.option_radio.click(function() {
            self.ajaxSaveAnswer($(this));
            self.displayAnswer($(this));
        });
    },

    ajaxSaveAnswer: function(handle) {
        $('.submission_buttons').addClass('disabled');
        $.post(routes.saveAnswerRoute, { answer: handle.val() } ,function(response) {
            $('.submission_buttons').removeClass('disabled');
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
        this.option_radio.prop('disabled', true);
    },

    clickAnswer: function(val) {
        $('.option_radio[value='+val+']').prop('checked', true);
        this.displayAnswer($(this));
    },

    displayPaperEndTime: function(end_time_in_seconds) {
        var timer = new Timer(), self = this;
        timer.start({countdown: true, startValues: {seconds: end_time_in_seconds}});

        self.countdown_timer.html(timer.getTimeValues().toString());

        timer.addEventListener('secondsUpdated', function (e) {
            self.countdown_timer.html(timer.getTimeValues().toString());
        });

        timer.addEventListener('targetAchieved', function (e) {
            self.endPaper();
        });
    },

    endPaper: function() {
        $.post(routes.showQuestionRoute, { submit: 'timed_out' }, function(response){
            window.location = routes.scorePageRoute;
        });
    },

    manuallyEndPaper: function() {
        var self = this;
        $('#end_paper').click(function() {
            if(confirm('Are you sure about ending the exam ?')) {
                self.endPaper();
            }
        });
    },
};
