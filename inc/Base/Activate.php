<?php
/**
 * @package KaTiSoft Plugin
 *
 */
namespace Inc\Base;

class Activate {
    public static function activate() {
        flush_rewrite_rules();

        $default = array();

		if ( ! get_option( 'katisoft_plugin' ) ) {
			update_option( 'katisoft_plugin', $default );
        }
        
        if ( ! get_option( 'katisoft_plugin_cpt' ) ) {
			update_option( 'katisoft_plugin_cpt', $default );
        }
        
        if ( ! get_option( 'katisoft_plugin_tax' ) ) {
			update_option( 'katisoft_plugin_tax', $default );
        }
        
        if ( ! get_option( 'katisoft_plugin_mail_smtp' ) ) {
			update_option( 'katisoft_plugin_mail_smtp', $default );
        }
        
        if ( ! get_option( 'katisoft_plugin_alo_phone' ) ) {
			update_option( 'katisoft_plugin_alo_phone', $default );
        }
        
        if ( ! get_option( 'katisoft_plugin_back_to_top' ) ) {
			update_option( 'katisoft_plugin_back_to_top', $default );
        }

        if ( ! get_option( 'katisoft_plugin_custom_login_page' ) ) {
			update_option( 'katisoft_plugin_custom_login_page', $default );
        }

        if ( ! get_option( 'katisoft_plugin_chat_facebook' ) ) {
			update_option( 'katisoft_plugin_chat_facebook', $default );
        }
    }
}