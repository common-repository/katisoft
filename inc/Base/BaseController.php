<?php
/**
 * @package Katisoft Plugin
 */
/*
Text Domain: katisoft
*/
namespace Inc\Base;

class BaseController
{
    public $plugin_path;

    public $plugin_url;

    public $plugin;

    public $managers = array();

    public function __construct() {
        $this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
        $this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
        $this->plugin = plugin_basename( dirname( __FILE__, 3 ) . '/katisoft.php' );

        $this->managers = array(
            'cpt_manager'               => 'Activate CPT Manager',
            'taxonomy_manager'          => 'Activate Taxonomy Manager',
            'mail_smtp_manager'         => 'Activate Mail SMTP Manager',
            'alo_phone_manager'         => 'Activate Alo Phone Manager',
            'back_to_top_manager'       => 'Activate Back To Top Manager',
            'custom_login_page_manager' => 'Activate Custom Login Page Manager',
            'testimonial_manager'       => 'Activate Testimonial Manager',
            'chat_facebook_manager'     => 'Activate Custom Chat Facebook',
            'login_manager'             => 'Activate Login/Signup Manager'
        );
    }

    public function activated( string $key )
	{
		$option = get_option( 'katisoft_plugin' );
		return isset( $option[ $key ] ) ? $option[ $key ] : false;
    }
}