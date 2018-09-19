<div class="wrap">
    <h1>Clientsdesk Plugin</h1>
    <?php settings_errors(); ?>

    <form method="post" action="options.php">
        <?php
        settings_fields( 'clientsdesk_options_group' );
        do_settings_sections( 'clientsdesk_settings' );
        submit_button();
        ?>
    </form>
</div>