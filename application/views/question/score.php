<h1 class="bottom_border">Score</h1>
<table class="u-full-width">
    <tbody>
        <tr>
            <th>Correct answers</th>
            <tH class="correct_text_color"><?php echo $score['correct_answer_count']; ?></tH>
        </tr>
        <tr>
            <th>Incorrect answers</th>
            <tH class="wrong_text_color"><?php echo $score['incorrect_answer_count']; ?></tH>
        </tr>
        <tr>
            <th>Number of attended questions</th>
            <tH><?php echo $score['correct_answer_count']+$score['incorrect_answer_count']; ?></tH>
        </tr>
            <th>Total questions</th>
            <tH><?php echo $score['total_questions']; ?></tH>
        </tr>
    </tbody>
</table>
<a href="<?php echo site_url('/'); ?>" class="button"><i class="fi-home"></i>&nbsp;Home</a>
<a href="<?php echo site_url('question/paper/'.$attended_paper_slug); ?>" class="button u-pull-right"><i class="fi-refresh"></i>&nbsp;Try again</a>

