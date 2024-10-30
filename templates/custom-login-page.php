<div class="wrap">
    <?php settings_errors(); ?>
    <form method="post" action="options.php">
        <?php 
            settings_fields( 'katisoft_plugin_custom_login_page_settings' );
            do_settings_sections( 'katisoft_custom_login_page' );
            submit_button();
        ?>
    </form>
</div>