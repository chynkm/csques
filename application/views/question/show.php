<form>
    <div class="row question_row">
        <div class="twelve columns">
            <?php echo $question['question']; ?>
            <?php echo get_answer_key_table($question); ?>
        </div>
    </div>

    <div class="row">
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body"><strong>A</strong>. <?php echo is_null($question['codes']) ? $question['option1'] : null; ?></span>
            </label>
        </div>
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body"><strong>B</strong>. <?php echo is_null($question['codes']) ? $question['option2'] : null; ?></span>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body"><strong>C</strong>. <?php echo is_null($question['codes']) ? $question['option3'] : null; ?></span>
            </label>
        </div>
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body"><strong>D</strong>. <?php echo is_null($question['codes']) ? $question['option4'] : null; ?></span>
            </label>
        </div>
    </div>

    <button class="button u-pull-right" type="button">Next</button>
</form>
