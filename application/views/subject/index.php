<?php foreach($subjects as $id => $subject): ?>
<h2>
    <a href="<?php echo base_url('subject/'.$id); ?>">
    <?php echo $subject; ?>
    </a>
</h2>
<?php endforeach; ?>
