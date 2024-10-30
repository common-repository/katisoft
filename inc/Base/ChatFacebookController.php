<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\ChatFacebookCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
/**
* 
*/
class ChatFacebookController extends BaseController
{
    public $settings;
	public $callbacks;
	public $chat_facebook_callbacks;
    public $subpages = array();
	public function register()
	{
		if ( ! $this->activated( 'chat_facebook_manager' ) ) return;
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue' ) );
		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->chat_facebook_callbacks = new ChatFacebookCallbacks();
		$this->setSubpages();

        $this->setSettings();
		$this->setSections();
		// $this->setFields();
		add_action( 'admin_init', function() {
			register_setting( 'katisoft_plugin_chat_facebook_settings', 'katisoft_plugin_chat_facebook' );
		});
		$this->settings->addSubPages( $this->subpages )->register();
		add_action( 'wp_ajax_update_options', array( $this, 'fbmcc_update_options' ) );
		add_action( 'wp_footer', array( $this, 'fbmcc_inject_messenger' ) );
	}
	
	public function enqueue()
	{
		wp_enqueue_style( 'chatfbstyle', $this->plugin_url . 'assets/chat-facebook.css' );
		wp_enqueue_script( 'chatfbscript', $this->plugin_url . 'assets/chat-facebook.js' );
	}

    public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'katisoft_plugin', 
				'page_title' => 'Custom Chat Facebook Manager', 
				'menu_title' => 'Custom Chat Facebook', 
				'capability' => 'manage_options', 
				'menu_slug' => 'katisoft_chat_facebook', 
				'callback' => array( $this->callbacks, 'adminChatFacebook' )
			)
		);
    }

    public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'katisoft_plugin_chat_facebook_settings',
				'option_name' => 'katisoft_plugin_chat_facebook',
				'callback' => array( $this->chat_facebook_callbacks, 'chatFacebookSanitize' )
			)
		);
		$this->settings->setSettings( $args );
	}
	public function setSections()
	{
		$args = array(
			array(
				'id' => 'katisoft_chat_facebook_index',
				'title' => 'Messenger Customer Chat Settings',
				'callback' => array( $this->chat_facebook_callbacks, 'chatFacebookSectionManager' ),
				'page' => 'katisoft_chat_facebook'
			)
		);
		$this->settings->setSections( $args );
    }
	
	public function fbmcc_update_options() {
		$katisoft_plugin_chat_facebook = get_option('katisoft_plugin_chat_facebook');
		$katisoft_plugin_chat_facebook['fbmcc_enabled'] = 1;
		$katisoft_plugin_chat_facebook['fbmcc_generatedCode'] = sanitize_textarea_field( $_POST['fbmcc_generatedCode'] );
		update_option( 'katisoft_plugin_chat_facebook', $katisoft_plugin_chat_facebook );
		// update_option( 'fbmcc_enabled', "1" );
		// update_option( 'fbmcc_generatedCode', sanitize_textarea_field( $_POST['fbmcc_generatedCode'] ) );
		wp_die();
	}

	public function fbmcc_inject_messenger() {
		$katisoft_plugin_chat_facebook = get_option('katisoft_plugin_chat_facebook');
		if( $katisoft_plugin_chat_facebook['fbmcc_enabled'] == '1'
		  && $katisoft_plugin_chat_facebook['fbmcc_generatedCode'] != ''
		) {
		  _e( stripslashes( $katisoft_plugin_chat_facebook['fbmcc_generatedCode'] ) );
		}
	  }
}