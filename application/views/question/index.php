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
<!-- <iframe src="<?php echo site_url('welcome/ajax_get_plugin'); ?>"></iframe> -->
<script type="text/javascript">
window.onload = function() {
    var element = document.createElement('iframe');
    element.setAttribute('class', 'xfeed_plugin');
    element.setAttribute('src', "<?php echo site_url('welcome/ajax_get_plugin'); ?>");
    element.style.border = 0;
    element.style.position = 'fixed';
    element.style.right = 0;
    element.style.bottom = 0;
    element.style.width = '100%';
    element.style.height = '100%';
    document.body.appendChild(element);

    /*var ajax = new XMLHttpRequest();
    var element = document.createElement('div');
    element.setAttribute('class', 'xfeed_plugin');
    ajax.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            element.innerHTML = this.responseText;
            document.body.appendChild(element);
            console.log(element.innerHTML);
            // document.getElementsByClassName('xfeed_plugin').addEventListener('click');
        }
    };
    ajax.open("GET", "<?php echo site_url('welcome/ajax_get_plugin'); ?>", true);
    ajax.send();*/
}
</script>
