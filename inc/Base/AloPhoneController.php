<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AloPhoneCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
/**
* 
*/
class AloPhoneController extends BaseController
{
    public $settings;
	public $callbacks;
	public $alo_phone_callbacks;
    public $subpages = array();
    public $alophone_options = array();
	public function register()
	{
		if ( ! $this->activated( 'alo_phone_manager' ) ) return;

		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->alo_phone_callbacks = new AloPhoneCallbacks();
        $this->setSubpages();
        $this->setSettings();
		$this->setSections();
		$this->setFields();
        $this->settings->addSubPages( $this->subpages )->register();

        $this->alophone_options = get_option('katisoft_plugin_alo_phone');
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
        add_action( 'wp_footer', array($this, 'aloPhone'));
    }

    public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'katisoft_plugin', 
				'page_title' => 'Alo Phone Manager', 
				'menu_title' => __('Custom Alo Phone', 'katisoft'), 
				'capability' => 'manage_options', 
				'menu_slug' => 'katisoft_alo_phone', 
				'callback' => array( $this->callbacks, 'adminAloPhone' )
			)
		);
    }

    public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'katisoft_plugin_alo_phone_settings',
				'option_name' => 'katisoft_plugin_alo_phone',
				'callback' => array( $this->alo_phone_callbacks, 'aloPhoneSanitize' )
			)
		);
		$this->settings->setSettings( $args );
	}
	public function setSections()
	{
		$args = array(
			array(
				'id' => 'katisoft_alo_phone_index',
				'title' => 'Alo Phone Settings',
				'callback' => array( $this->alo_phone_callbacks, 'aloPhoneSectionManager' ),
				'page' => 'katisoft_alo_phone'
			)
		);
		$this->settings->setSections( $args );
	}
	public function setFields()
	{
		$args = array(
			array(
				'id' => 'phone_number',
				'title' => 'Phone Number',
				'callback' => array( $this->alo_phone_callbacks, 'textField' ),
				'page' => 'katisoft_alo_phone',
				'section' => 'katisoft_alo_phone_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_alo_phone',
					'label_for' => 'phone_number',
					'placeholder' => 'eg. 0905160320',
					'array' => 'phone_number'
				)
			),
			array(
				'id' => 'button_text',
				'title' => 'Button Text',
				'callback' => array( $this->alo_phone_callbacks, 'textField' ),
				'page' => 'katisoft_alo_phone',
				'section' => 'katisoft_alo_phone_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_alo_phone',
					'label_for'   => 'button_text',
					'placeholder' => 'eg. CALL ME',
					'description' => 'Leave blank if you want to hide text',
					'array' 	  => 'button_text'
				)
            ),
            array(
                'id' => 'position_left',
                'title' => 'Position Left',
                'callback' => array( $this->alo_phone_callbacks, 'textField' ),
                'page' => 'katisoft_alo_phone',
                'section' => 'katisoft_alo_phone_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_alo_phone',
                    'label_for' => 'position_left',
                    'placeholder' => 'eg. 10px or 10%',
                    'array' => 'position_left'
                )
            ),
            array(
                'id' => 'position_bottom',
                'title' => 'Position Bottom',
                'callback' => array( $this->alo_phone_callbacks, 'textField' ),
                'page' => 'katisoft_alo_phone',
                'section' => 'katisoft_alo_phone_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin_alo_phone',
                    'label_for' => 'position_bottom',
                    'placeholder' => 'eg. 10px or 10%',
                    'array' => 'position_bottom'
                )
            )
        );
        $this->settings->setFields( $args );
    }

    public function enqueue() {
		wp_enqueue_style( 'alophonestyle', $this->plugin_url . 'assets/css/alo-phone.css' );
	}

    public function aloPhone () {
		$phone = isset($this->alophone_options['phone_number']) ? $this->alophone_options['phone_number'] : '';
		$button_text = isset($this->alophone_options['button_text']) ? $this->alophone_options['button_text'] : '';
        $left = isset($this->alophone_options['position_left']) ? $this->alophone_options['position_left'] : '0px';
        $bottom = isset($this->alophone_options['position_bottom']) ? $this->alophone_options['position_bottom'] : '0px';
		$html  = '';
		$html .=	'<a href="tel://'. $phone .'" class="fancybox">';
		$html .= '		<div class="coccoc-alo-phone coccoc-alo-green coccoc-alo-show" id="coccoc-alo-phoneIcon" style="left:'. $left .'; bottom: '. $bottom .';">';
		if($button_text != ''){
			$html .= '			<p class="coccoc-alo-text">';
			$html .= '				<strong>'. $button_text .'</strong>';
			$html .= '			</p>';
		}
		$html .= '			<div class="coccoc-alo-ph-circle"></div>';
		$html .= '			<div class="coccoc-alo-ph-circle-fill"></div><div class="coccoc-alo-ph-img-circle"></div>';
		$html .= '		</div>';
		$html .= '	</a>';

		echo $html;
    }
}