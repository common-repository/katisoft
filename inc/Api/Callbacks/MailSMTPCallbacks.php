<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Api\Callbacks;
class MailSMTPCallbacks
{
	public function mailSMTPSectionManager()
	{
		echo 'WP Mail SMTP fixes your email deliverability by reconfiguring the wp_mail() PHP function to use a proper SMTP provider.';
    }

    public function mailSMTPSanitize( $input )
    {
        return $input;
    }

    public function textField( $args )
	{
		$name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
		$value = isset($input[$name]) ? $input[$name] : '';
		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required>';
    }

    public function passField( $args )
	{
		$name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
		$value = isset($input[$name]) ? $input[$name] : '';
		echo '<input type="password" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required>';
    }
    
    public function secureRadio( $args )
	{
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        $value = $input[$name];

        $html = '<input type="radio" id="secure_radio_one" name="' . $option_name . '[' . $name . ']" value="none"' . checked( 'none', $value, false ) . '/>';
        $html .= '<label for="secure_radio_one" style="margin-right: 30px;">None</label>';
     
        $html .= '<input type="radio" id="secure_radio_two" name="' . $option_name . '[' . $name . ']" value="ssl"' . checked( 'ssl', $value, false ) . '/>';
        $html .= '<label for="secure_radio_two" style="margin-right: 30px;">SSL</label>';
        
        $html .= '<input type="radio" id="secure_radio_three" name="' . $option_name . '[' . $name . ']" value="tls"' . checked( 'tls', $value, false ) . '/>';
        $html .= '<label for="secure_radio_three">TLS</label>';
        
        echo $html;
    }
    
    public function authRadio( $args )
	{
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        $value = $input[$name];
     
        $html = '<input type="radio" id="auth_radio_two" name="' . $option_name . '[' . $name . ']" value="no"' . checked( 'no', $value, false ) . '/>';
        $html .= '<label for="auth_radio_two" style="margin-right: 30px;">No</label>';
        
        $html .= '<input type="radio" id="auth_radio_three" name="' . $option_name . '[' . $name . ']" value="yes"' . checked( 'yes', $value, false ) . '/>';
        $html .= '<label for="auth_radio_three">Yes</label>';
        
        echo $html;
	}
}