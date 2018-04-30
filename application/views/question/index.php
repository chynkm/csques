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
<img src="http://localhost/xfeed/minus.png" alt="xfeed" id="xfeed_button" width="50px" style="position: fixed; right: 0px; bottom: 0px;">
<script type="text/javascript">
document.getElementById('xfeed_button').addEventListener('click', function() {
    var element = document.createElement('iframe');
    element.setAttribute('class', 'xfeed_plugin');
    element.setAttribute('id', 'xfeed_id_plugin');
    element.setAttribute('src', "http://localhost/xfeed/plugin.html");
    element.style.border = 0;
    element.style.position = 'fixed';
    element.style.right = 0;
    element.style.bottom = 0;
    element.style.width = '100%';
    element.style.height = '100%';
    // element.style.zIndex = 1000;
    document.body.appendChild(element);
});

</script>




