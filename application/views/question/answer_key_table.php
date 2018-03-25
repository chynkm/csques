<strong>Codes</strong>
<table class="table_bordered">
    <thead>
        <tr>
            <th></th>
            <?php foreach ($codes as $key => $code): ?>
            <th><?php echo trim($code); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($answers as $key => $answer): ?>
        <tr>
            <th><?php echo $key; ?></th>
            <?php foreach ($answer as $key => $option_value): ?>
            <td><?php echo trim($option_value); ?></td>
            <?php endforeach; ?>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
