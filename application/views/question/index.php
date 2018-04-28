<table class="u-full-width">
  <thead>
    <tr>
      <th>#</th>
      <th>Question</th>
      <th>Codes</th>
      <th>Option 1</th>
      <th>Option 2</th>
      <th>Option 3</th>
      <th>Option 4</th>
      <th>Answer</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($questions as $key => $question):?>
    <tr>
      <td><?php echo $question['id']; ?></td>
      <td><?php echo $question['question']; ?></td>
      <td><?php echo $question['codes']; ?></td>
      <td><?php echo $question['option1']; ?></td>
      <td><?php echo $question['option2']; ?></td>
      <td><?php echo $question['option3']; ?></td>
      <td><?php echo $question['option4']; ?></td>
      <td><?php echo $question['answer']; ?></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
<script src="<?php echo asset_url('js/xfeed.js'); ?>"></script>
