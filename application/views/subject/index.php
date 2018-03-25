<?php foreach($subjects as $slug => $subject): ?>
<h2>
    <a href="<?php echo site_url('subject/'.$slug); ?>">
    <?php echo $subject; ?>
    </a>
</h2>
<?php endforeach; ?>
