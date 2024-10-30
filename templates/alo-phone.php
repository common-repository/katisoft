<div class="wrap">
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php 
            settings_fields( 'katisoft_plugin_alo_phone_settings' );
            do_settings_sections( 'katisoft_alo_phone' );
            submit_button();
        ?>
    </form>
</div>