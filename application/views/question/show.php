<h1 class="bottom_border">Question <?php echo $question['fake_id']; ?></h1>
<form method="post">
    <div class="row question_row">
        <div class="twelve columns">
            <?php echo $question['question']; ?>
            <?php echo get_answer_key_table($question); ?>
        </div>
    </div>

    <div class="row">
        <div class="six columns question_options">
            <label class="option_label">
                <input type="radio" class="option_radio" value="A">
                <span class="option_label_body"><strong>A</strong>. <?php echo is_null($question['codes']) ? $question['option1'] : null; ?></span>
                <i class="answer_icon"></i>
            </label>
        </div>
        <div class="six columns question_options">
            <label class="option_label">
                <input type="radio" class="option_radio" value="B">
                <span class="option_label_body"><strong>B</strong>. <?php echo is_null($question['codes']) ? $question['option2'] : null; ?></span>
                <i class="answer_icon"></i>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="six columns question_options">
            <label class="option_label">
                <input type="radio" class="option_radio" value="C">
                <span class="option_label_body"><strong>C</strong>. <?php echo is_null($question['codes']) ? $question['option3'] : null; ?></span>
                <i class="answer_icon"></i>
            </label>
        </div>
        <div class="six columns question_options">
            <label class="option_label">
                <input type="radio" class="option_radio" value="D">
                <span class="option_label_body"><strong>D</strong>. <?php echo is_null($question['codes']) ? $question['option4'] : null; ?></span>
                <i class="answer_icon"></i>
            </label>
        </div>
    </div>

    <input type="hidden" id="answer" name="answer">
    <input type="hidden" id="correct_answer" value="<?php echo $question['answer']; ?>">
    <?php if($this->session->userdata('question_trial_paper_id') > $this->session->userdata('question_trial_paper_min_id')): ?>
    <button class="button" type="submit" name="submit" value="previous"><i class="fi-arrow-left"></i>&nbsp;Previous</button>
    <?php endif; ?>
    <?php if($this->session->userdata('question_trial_paper_id') < $this->session->userdata('question_trial_paper_max_id')): ?>
    <button class="button u-pull-right" type="submit" name="submit" value="next">Next&nbsp;<i class="fi-arrow-right"></i></button>
    <?php endif; ?>
    <?php if($this->session->userdata('question_trial_paper_id') == $this->session->userdata('question_trial_paper_max_id')): ?>
    <button class="button-primary u-pull-right" type="submit" name="submit" value="end_paper">Submit</button>
    <?php endif; ?>
</form>
<script src="<?php echo asset_url('js/zepto.min.js'); ?>"></script>
<script src="<?php echo asset_url('js/question_show.js'); ?>"></script>
<?php if(! is_null($question['user_answer'])): ?>
<script type="text/javascript">
APP.question_show.clickAnswer("<?php echo $question['user_answer']; ?>");
</script>
<?php endif; ?>
