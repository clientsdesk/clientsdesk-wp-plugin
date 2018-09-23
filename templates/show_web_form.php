<div class="wrap">
    <h1>Form </h1>
    <?php

    var_dump($response['web_form']);


    ?>

    <h4>Shortcode</h4>
    <code><?php echo '[clientsdesk form_id="'. $response['web_form']['hash_id'] .'"]'; ?></code>


    <h4>HTML</h4>
    <textarea disabled cols="160" rows="<?php echo substr_count( $response['web_form']['html'], "\n" ); ?>"><?php echo  htmlspecialchars(html_entity_decode( $response['web_form']['html']), ENT_QUOTES); ?></textarea>

</div>
