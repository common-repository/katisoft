<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\CustomLoginPageCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
/**
* 
*/
class CustomLoginPageController extends BaseController
{
    public $settings;
	public $callbacks;
	public $custom_login_page_callbacks;
    public $subpages = array();
    public $customloginpage_options = array();
	public function register()
	{
		if ( ! $this->activated( 'custom_login_page_manager' ) ) return;

		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->custom_login_page_callbacks = new CustomLoginPageCallbacks();
        $this->setSubpages();
        $this->setSettings();
		$this->setSections();
		$this->setFields();
        $this->settings->addSubPages( $this->subpages )->register();
        
        $this->customloginpage_options = get_option('katisoft_plugin_custom_login_page');
        add_action('login_head', array( $this, 'katisoftCustomLogin' ));
    }

    public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'katisoft_plugin', 
				'page_title' => 'Custom Login Page Manager', 
				'menu_title' => 'Custom Admin Login', 
				'capability' => 'manage_options', 
				'menu_slug' => 'katisoft_custom_login_page', 
				'callback' => array( $this->callbacks, 'adminCustomLoginPage' )
			)
		);
    }

    public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'katisoft_plugin_custom_login_page_settings',
				'option_name' => 'katisoft_plugin_custom_login_page',
				'callback' => array( $this->custom_login_page_callbacks, 'customLoginPageSanitize' )
			)
		);
		$this->settings->setSettings( $args );
	}
	public function setSections()
	{
		$args = array(
			array(
				'id' => 'katisoft_custom_login_page_index',
				'title' => 'Custom Login Page Settings',
				'callback' => array( $this->custom_login_page_callbacks, 'customLoginPageSectionManager' ),
				'page' => 'katisoft_custom_login_page'
			)
		);
		$this->settings->setSections( $args );
    }
    
	public function setFields()
	{
		$args = array(
            array(
                'id' => 'background_color',
                'title' => 'Background Color',
                'callback' => array( $this->custom_login_page_callbacks, 'colorPickerField' ),
                'page' => 'katisoft_custom_login_page',
                'section' => 'katisoft_custom_login_page_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_custom_login_page',
                    'label_for' => 'background_color',
                    'placeholder' => '#f1f1f1',
                    'array' => 'background_color'
                )
            ),
            array(
                'id' => 'background_image',
                'title' => 'Background Image',
                'callback' => array( $this->custom_login_page_callbacks, 'uploadBgImageField' ),
                'page' => 'katisoft_custom_login_page',
                'section' => 'katisoft_custom_login_page_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_custom_login_page',
                    'label_for' => 'background_image',
                    'array' => 'background_image'
                )
            ),
            array(
                'id' => 'logo_image',
                'title' => 'Logo Image',
                'callback' => array( $this->custom_login_page_callbacks, 'uploadLogoImageField' ),
                'page' => 'katisoft_custom_login_page',
                'section' => 'katisoft_custom_login_page_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_custom_login_page',
                    'label_for' => 'logo_image',
                    'array' => 'logo_image'
                )
            )
        );
        $this->settings->setFields( $args );
    }

    public function katisoftCustomLogin()
    {
        $bg_color = isset($this->customloginpage_options['background_color']) ? $this->customloginpage_options['background_color'] : '#f1f1f1';
        $bg_img = isset($this->customloginpage_options['background_image']) ? $this->customloginpage_options['background_image'] : '';
        $logo_img = isset($this->customloginpage_options['logo_image']) ? $this->customloginpage_options['logo_image'] : '';

        $style = '<style>';
        $style .= 'Body.login';
        $style .= '{';
        $style .= 'background-color: '. $bg_color .';';
        $style .= 'background-image:url("'. $bg_img .'");';
        $style .= '}';
        $style .= '#login h1 a {';
        $style .= 'background-image: url("'. $logo_img .'");';
        $style .= 'width: 200px;';
        $style .= 'height: 85px;';
        $style .= 'margin: 0 auto;';
        $style .= 'overflow: unset;';
        $style .= 'background-size: 100%;';
        $style .= '}';
        $style .= '</style>';
        echo $style;
    }
}