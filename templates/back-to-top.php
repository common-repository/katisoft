<div class="wrap">
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php 
            settings_fields( 'katisoft_plugin_back_to_top_settings' );
            do_settings_sections( 'katisoft_back_to_top' );
            submit_button();
        ?>
    </form>
</div>