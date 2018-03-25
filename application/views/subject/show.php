<table class="u-full-width">
    <thead>
        <tr>
            <th class="th_exam">Exam</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($exams as $id => $exam): ?>
        <tr>
            <td><?php echo $exam; ?></td>
            <td>
                <a href="<?php echo base_url('question/index/'.$id); ?>" class="button">List</a>
                <a href="<?php echo base_url('question/exam/'.$id); ?>" class="button">Try</a>
                <button class="button-primary">Test</button>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

