<h1 class="bottom_border"><?php echo $subject; ?>&nbsp;papers</h1>
<table class="u-full-width">
    <thead>
        <tr>
            <th class="th_exam">Paper</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($papers as $slug => $paper): ?>
        <tr>
            <td><?php echo $paper; ?></td>
            <td>
                <a href="<?php echo site_url('question/index/'.$slug); ?>" class="button">List</a>
                <a href="<?php echo site_url('question/paper/'.$slug); ?>" class="button">Try</a>
                <button class="button-primary">Test</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

