<center><h1 class="bottom_border theme_color"><?php echo $subject; ?>&nbsp;papers</h1></center>
<table class="u-full-width">
    <thead>
        <tr>
            <th class="th_exam">Paper</th>
            <th>No. of questions</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($papers as $paper): ?>
        <tr>
            <td><?php echo $paper['name']; ?></td>
            <td><?php echo $paper['question_count']; ?></td>
            <td>
                <a href="<?php echo site_url('question/paper/'.$paper['slug']); ?>" class="button">Try</a>
                <a href="<?php echo site_url('question/paper/'.$paper['slug'].'/test'); ?>" class="button">Test</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

