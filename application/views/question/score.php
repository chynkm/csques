<h1 class="bottom_border theme_color">Score</h1>
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
<a href="<?php echo site_url('subject/'.$attended_paper_slug_and_subject_slug['subject_slug']); ?>" class="button"><i class="fi-home"></i>&nbsp;Subject home</a>
<a href="<?php echo site_url('question/paper/'.$attended_paper_slug_and_subject_slug['paper_slug'].($this->session->paper_end_time ? '/true' : '')); ?>" class="button u-pull-right"><i class="fi-refresh"></i>&nbsp;Try again</a>

