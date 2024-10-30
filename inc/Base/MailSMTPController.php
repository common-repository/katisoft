<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Base;
use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\MailSMTPCallbacks;
use Inc\Api\Callbacks\AdminCallbacks;
/**
* 
*/
class MailSMTPController extends BaseController
{
    public $settings;
	public $callbacks;
	public $mail_smtp_callbacks;
	public $subpages = array();
	public $smpt_options = array();
	public function register()
	{
		if ( ! $this->activated( 'mail_smtp_manager' ) ) return;

		$this->settings = new SettingsApi();
		$this->callbacks = new AdminCallbacks();
		$this->mail_smtp_callbacks = new MailSMTPCallbacks();
        $this->setSubpages();
        $this->setSettings();
		$this->setSections();
		$this->setFields();
		$this->settings->addSubPages( $this->subpages )->register();

		$this->smpt_options = get_option('katisoft_plugin_mail_smtp');
		if ( empty ($this->smpt_options) ) return;
		add_action( 'phpmailer_init', array( $this, 'wp_smtp' ) );
    }
    
    public function setSubpages()
	{
		$this->subpages = array(
			array(
				'parent_slug' => 'katisoft_plugin', 
				'page_title' => 'Mail SMTP Manager', 
				'menu_title' => 'Custom Mail SMTP', 
				'capability' => 'manage_options', 
				'menu_slug' => 'katisoft_mail_smtp', 
				'callback' => array( $this->callbacks, 'adminMailSMTP' )
			)
		);
    }
    public function setSettings()
	{
		$args = array(
			array(
				'option_group' => 'katisoft_plugin_mail_smtp_settings',
				'option_name' => 'katisoft_plugin_mail_smtp',
				'callback' => array( $this->mail_smtp_callbacks, 'mailSMTPSanitize' )
			)
		);
		$this->settings->setSettings( $args );
	}
	public function setSections()
	{
		$args = array(
			array(
				'id' => 'katisoft_mail_smtp_index',
				'title' => 'Mail',
				'callback' => array( $this->mail_smtp_callbacks, 'mailSMTPSectionManager' ),
				'page' => 'katisoft_mail_smtp'
			)
		);
		$this->settings->setSections( $args );
	}
	public function setFields()
	{
		$args = array(
			array(
				'id' => 'from_email',
				'title' => 'From Email',
				'callback' => array( $this->mail_smtp_callbacks, 'textField' ),
				'page' => 'katisoft_mail_smtp',
				'section' => 'katisoft_mail_smtp_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_mail_smtp',
					'label_for' => 'from_email',
					'placeholder' => 'eg. website@example.com',
					'array' => 'from_email'
				)
			),
			array(
				'id' => 'from_name',
				'title' => 'From Name',
				'callback' => array( $this->mail_smtp_callbacks, 'textField' ),
				'page' => 'katisoft_mail_smtp',
				'section' => 'katisoft_mail_smtp_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_mail_smtp',
					'label_for' => 'from_name',
					'placeholder' => 'eg. Website Name',
					'array' => 'from_name'
				)
			),
			array(
				'id' => 'smtp_host',
				'title' => 'SMTP Host',
				'callback' => array( $this->mail_smtp_callbacks, 'textField' ),
				'page' => 'katisoft_mail_smtp',
				'section' => 'katisoft_mail_smtp_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_mail_smtp',
					'label_for' => 'smtp_host',
					'placeholder' => 'eg. smtp.example.com',
					'array' => 'smtp_host'
				)
			),
			array(
				'id' => 'smtp_secure',
				'title' => 'SMTP Secure',
				'callback' => array( $this->mail_smtp_callbacks, 'secureRadio' ),
				'page' => 'katisoft_mail_smtp',
				'section' => 'katisoft_mail_smtp_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_mail_smtp',
					'label_for' => 'smtp_secure',
					'array' => 'smtp_secure'
				)
			),
			array(
				'id' => 'smtp_port',
				'title' => 'SMTP Port',
				'callback' => array( $this->mail_smtp_callbacks, 'textField' ),
				'page' => 'katisoft_mail_smtp',
				'section' => 'katisoft_mail_smtp_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_mail_smtp',
					'label_for' => 'smtp_port',
					'placeholder' => 'eg. 587',
					'array' => 'smtp_port'
				)
			),
			array(
				'id' => 'smtp_auth',
				'title' => 'SMTP Authentication',
				'callback' => array( $this->mail_smtp_callbacks, 'authRadio' ),
				'page' => 'katisoft_mail_smtp',
				'section' => 'katisoft_mail_smtp_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_mail_smtp',
					'label_for' => 'smtp_auth',
					'array' => 'smtp_auth'
				)
			),
			array(
				'id' => 'smtp_username',
				'title' => 'SMTP Username',
				'callback' => array( $this->mail_smtp_callbacks, 'textField' ),
				'page' => 'katisoft_mail_smtp',
				'section' => 'katisoft_mail_smtp_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_mail_smtp',
					'label_for' => 'smtp_username',
					'placeholder' => 'eg. user@example.com',
					'array' => 'smtp_username'
				)
			),
			array(
				'id' => 'smtp_password',
				'title' => 'SMTP Password',
				'callback' => array( $this->mail_smtp_callbacks, 'passField' ),
				'page' => 'katisoft_mail_smtp',
				'section' => 'katisoft_mail_smtp_index',
				'args' => array(
					'option_name' => 'katisoft_plugin_mail_smtp',
					'label_for' => 'smtp_password',
					'placeholder' => 'eg. smtp password',
					'array' => 'smtp_password'
				)
			)
		);
		$this->settings->setFields( $args );
	}

	public function wp_smtp($phpmailer)
	{
		if( ! is_email($this->smpt_options["from_email"] ) || empty( $this->smpt_options["smtp_host"] ) ) {
			return;
		}

		$phpmailer->isSMTP();
		$phpmailer->Host       = $this->smpt_options['smtp_host'];
		$phpmailer->SMTPAuth   = ($this->smpt_options['smtp_auth']=="yes") ? TRUE : FALSE;
		$phpmailer->Port       = $this->smpt_options['smtp_port'];
		$phpmailer->SMTPSecure = $this->smpt_options['smtp_secure'];
		$phpmailer->From       = $this->smpt_options['from_email'];
		$phpmailer->FromName   = $this->smpt_options['from_name'];

		if( $phpmailer->SMTPAuth ){
			$phpmailer->Username   = $this->smpt_options['smtp_username'];
			$phpmailer->Password   = $this->smpt_options['smtp_password'];
		}
	}
}