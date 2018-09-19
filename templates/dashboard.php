<div class="wrap">
    <h1>Form list</h1>
    <?php
    echo '<table>';
    foreach ($response['web_forms'] as $form) {
        echo '<tr>
            <td>' . $form['id'] . '</td>
            <td>' . $form['title'] . '</td>
            <td>' . $form['hash_id'] . '</td>
            <td><a href="admin.php?page=clientsdesk_dashboard&form_id=' .  $form['hash_id'] . '">View form</a></td>
            </tr>';
    }
    echo '</table>';

    ?>

</div>
