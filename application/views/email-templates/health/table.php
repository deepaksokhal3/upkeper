
<table id="customers">
    <tr>
        <th>Plugins</th>
        <th>New Version</th>
    </tr>
    <?php foreach ($plugins as $key => $plugin) : ?>

        <tr>
            <td><?= $plugin->Name; ?> </td>
            <td><?= $plugin->update->new_version; ?></td>
        </tr>
    <?php endforeach; ?>

</table>  