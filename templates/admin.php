<div class="wrap">
    <h1>KaTiSoft Plugin</h1>
    <?php settings_errors(); ?>

    <ul class="nav nav-tabs">
        <li class="active"><a href="#tab-1"><?php _e('Manage Settings', 'katisoft') ?></a></li>
        <li><a href="#tab-2"><?php _e('Updates', 'katisoft') ?></a></li>
        <li><a href="#tab-3"><?php _e('About', 'katisoft') ?></a></li>
    </ul>

    <div class="tab-content">
        <div id="tab-1" class="tab-pane active">
            <form method="post" action="options.php">
                <?php
                    settings_fields( 'katisoft_plugin_settings' );
                    do_settings_sections( 'katisoft_plugin' );
                    submit_button();
                ?>
            </form>
        </div>
        <div id="tab-2" class="tab-pane">
            <h3>Updates</h3>
            <p>
                <strong>** 16/05/2019 | Update Katisoft Plugin (v1.0.6)</strong><br>
                - Add Button text in the Alo Phone Moduler.<br><br>
                <strong>** 15/05/2019 | Update Katisoft Plugin (v1.0.5)</strong><br>
                - Add Chat Facebook Manager - Messenger Facebook Fan Page.<br><br>
                <strong>** 27/04/2019 | Update Katisoft Plugin (v1.0.4)</strong><br>
                - Add Custom Login Page Manager - Custom Login Page in Admin.<br><br>
                <strong>** 24/04/2019 | Update Katisoft Plugin (v1.0.3)</strong><br>
                - Add Back To Top Manager - Back To Top Icon In Frontend.<br><br>
                <strong>** 19/04/2019 | Update Katisoft Plugin (v1.0.2)</strong><br>
                - Add Alo Phone Manager - Alo Phone Icon Ring Ring In Frontend.<br><br>
                <strong>** 17/04/2019 | Updated Katisoft Plugin (v1.0.1)</strong><br>
                - Add WP Mail SMTP Manager - Config WP_MAIL<br><br>
                <strong>** 13/04/2019 | Initialize The Katisoft Plugin (v1.0.0)</strong><br>
                - Moduler Adminstrator Area.<br>
                - Custom Post Type Manager.<br>
                - Custom Taxonomy Manager | Add Taxonomy For Post Type.<br>
                - Widget To Upload And Display Media In Sidebars.<br>
                - Ajax Based Login/Register System.<br>
                - Gutenburg Blocks.
            </p>
            
        </div>
        <div id="tab-3" class="tab-pane">
            <h3>About</h3>
            <p>
                Katisoft Plugin Developed By Thiện Phạm<br>
                Skype: chithien175
            </p>
        </div>
    </div>
</div>
