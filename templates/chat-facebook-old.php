<div class="wrap">
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php 
            settings_fields( 'katisoft_plugin_chat_facebook_settings' );
            do_settings_sections( 'katisoft_chat_facebook' );
            submit_button();
        ?>
    </form>
</div>