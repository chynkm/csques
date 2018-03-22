<form>
    <div class="row question_row">
        <div class="twelve columns">
            <?php echo $question['question']; ?>
        </div>
    </div>
    <div class="row">
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="label-body"><strong>A</strong>. <?php echo $question['option1']; ?></span>
            </label>
        </div>
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="label-body"><strong>B</strong>. <?php echo $question['option2']; ?></span>
            </label>
        </div>
    </div>
    <div class="row">
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="label-body"><strong>C</strong>. <?php echo $question['option3']; ?></span>
            </label>
        </div>
        <div class="six columns">
            <label>
                <input type="radio" name="answer" value="A">
                <span class="label-body"><strong>D</strong>. <?php echo $question['option4']; ?></span>
            </label>
        </div>
    </div>
    <button class="button u-pull-right" type="button">Next</button>
</form>
