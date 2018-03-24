<form>
    <div class="row question_row">
        <div class="twelve columns">
            <?php echo $question['id'].' '.$question['question']; ?>
        </div>
    </div>

    <?php if(is_null($question['codes'])): ?>
    <div class="row">
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body"><strong>A</strong>. <?php echo $question['option1']; ?></span>
            </label>
        </div>
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body"><strong>B</strong>. <?php echo $question['option2']; ?></span>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body"><strong>C</strong>. <?php echo $question['option3']; ?></span>
            </label>
        </div>
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body"><strong>D</strong>. <?php echo $question['option4']; ?></span>
            </label>
        </div>
    </div>
    <?php else: ?>
    <div class="row">
        <div class="twelve columns">
            <?php echo $question['codes']; ?>
        </div>
        <div class="twelve columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body show_space"><strong>A</strong>. <?php echo $question['option1']; ?></span>
            </label>
        </div>
        <div class="twelve columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body show_space"><strong>B</strong>. <?php echo $question['option2']; ?></span>
            </label>
        </div>
        <div class="twelve columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body show_space"><strong>C</strong>. <?php echo $question['option3']; ?></span>
            </label>
        </div>
        <div class="twelve columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="option_label_body show_space"><strong>D</strong>. <?php echo $question['option4']; ?></span>
            </label>
        </div>
    </div>
    <?php endif; ?>
    <button class="button u-pull-right" type="button">Next</button>
</form>
