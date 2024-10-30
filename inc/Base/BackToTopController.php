<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\BackToTopCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
/**
* 
*/
class BackToTopController extends BaseController
{
    public $settings;
	public $callbacks;
	public $back_to_top_callbacks;
    public $subpages = array();
    public $backtotop_options = array();
	public function register()
	{
		if ( ! $this->activated( 'back_to_top_manager' ) ) return;

		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->back_to_top_callbacks = new BackToTopCallbacks();
        $this->setSubpages();
        $this->setSettings();
		$this->setSections();
		$this->setFields();
        $this->settings->addSubPages( $this->subpages )->register();
        
        $this->backtotop_options = get_option('katisoft_plugin_back_to_top');
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_action( 'wp_footer', array($this, 'backToTop'));
    }

    public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'katisoft_plugin', 
				'page_title' => 'Back To Top Manager', 
				'menu_title' => 'Custom Back To Top', 
				'capability' => 'manage_options', 
				'menu_slug' => 'katisoft_back_to_top', 
				'callback' => array( $this->callbacks, 'adminBackToTop' )
			)
		);
    }

    public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'katisoft_plugin_back_to_top_settings',
				'option_name' => 'katisoft_plugin_back_to_top',
				'callback' => array( $this->back_to_top_callbacks, 'backToTopSanitize' )
			)
		);
		$this->settings->setSettings( $args );
	}
	public function setSections()
	{
		$args = array(
			array(
				'id' => 'katisoft_back_to_top_index',
				'title' => 'Back To Top Settings',
				'callback' => array( $this->back_to_top_callbacks, 'backToTopSectionManager' ),
				'page' => 'katisoft_back_to_top'
			)
		);
		$this->settings->setSections( $args );
	}
	public function setFields()
	{
		$args = array(
            array(
                'id' => 'background_color',
                'title' => 'Button Color',
                'callback' => array( $this->back_to_top_callbacks, 'colorPickerField' ),
                'page' => 'katisoft_back_to_top',
                'section' => 'katisoft_back_to_top_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_back_to_top',
                    'label_for' => 'background_color',
                    'placeholder' => '#FF9800',
                    'array' => 'background_color'
                )
            ),
            array(
                'id' => 'position_right',
                'title' => 'Button Position Right',
                'callback' => array( $this->back_to_top_callbacks, 'textField' ),
                'page' => 'katisoft_back_to_top',
                'section' => 'katisoft_back_to_top_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_back_to_top',
                    'label_for' => 'position_right',
                    'placeholder' => 'eg. 10px or 10%',
                    'array' => 'position_right'
                )
            ),
            array(
                'id' => 'position_bottom',
                'title' => 'Button Position Bottom',
                'callback' => array( $this->back_to_top_callbacks, 'textField' ),
                'page' => 'katisoft_back_to_top',
                'section' => 'katisoft_back_to_top_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_back_to_top',
                    'label_for' => 'position_bottom',
                    'placeholder' => 'eg. 10px or 10%',
                    'array' => 'position_bottom'
                )
            ),
            array(
                'id' => 'width_button',
                'title' => 'Button Width',
                'callback' => array( $this->back_to_top_callbacks, 'textField' ),
                'page' => 'katisoft_back_to_top',
                'section' => 'katisoft_back_to_top_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_back_to_top',
                    'label_for' => 'width_button',
                    'placeholder' => 'eg. 50px',
                    'array' => 'width_button'
                )
            ),
            array(
                'id' => 'height_button',
                'title' => 'Button Height',
                'callback' => array( $this->back_to_top_callbacks, 'textField' ),
                'page' => 'katisoft_back_to_top',
                'section' => 'katisoft_back_to_top_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_back_to_top',
                    'label_for' => 'height_button',
                    'placeholder' => 'eg. 50px',
                    'array' => 'height_button'
                )
            ),
            array(
                'id' => 'padding_top',
                'title' => 'Button Padding Top',
                'callback' => array( $this->back_to_top_callbacks, 'textField' ),
                'page' => 'katisoft_back_to_top',
                'section' => 'katisoft_back_to_top_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_back_to_top',
                    'label_for' => 'padding_top',
                    'placeholder' => 'eg. 10px',
                    'array' => 'padding_top'
                )
            )
        );
        $this->settings->setFields( $args );
    }

    public function enqueue() {
        wp_enqueue_style( 'backtotop-style', $this->plugin_url . 'assets/css/back-to-top.css' );
        wp_enqueue_script( 'backtotop-scripts', $this->plugin_url . 'assets/js/back-to-top.js', array( 'jquery' ),'',true );
	}

    public function backToTop () {
        $bg_color = isset($this->backtotop_options['background_color']) ? $this->backtotop_options['background_color'] : '';
        $right = isset($this->backtotop_options['position_right']) ? $this->backtotop_options['position_right'] : '0px';
        $bottom = isset($this->backtotop_options['position_bottom']) ? $this->backtotop_options['position_bottom'] : '0px';
        $width = isset($this->backtotop_options['width_button']) ? $this->backtotop_options['width_button'] : '50px';
        $height = isset($this->backtotop_options['height_button']) ? $this->backtotop_options['height_button'] : '50px';
        $padding_top = isset($this->backtotop_options['padding_top']) ? $this->backtotop_options['padding_top'] : '50px';

        echo '<a id="back-to-top" style="right: '. $right .'; bottom: '. $bottom .'; background-color: '. $bg_color .'; width: '. $width .'; height: '. $height .'; padding-top: '. $padding_top .';">
			<i class="fas fa-angle-double-up"></i>
		</a>';
    }

}