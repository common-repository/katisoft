<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Api\Callbacks;
class AloPhoneCallbacks
{
	public function aloPhoneSectionManager()
	{
		echo 'The configuration shows the "Phone Ring" icon outside the frontend.';
    }

    public function aloPhoneSanitize( $input )
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
        if(isset($args['description'])){
            echo '<p class="description" id="'. $name .'-description">'. $args['description'] .'</p>';
        }
    }
}