<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Api\Callbacks;
class BackToTopCallbacks
{
	public function backToTopSectionManager()
	{
		echo 'The configuration shows the "Back To Top" icon outside the frontend.';
    }

    public function backToTopSanitize( $input )
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

    public function colorPickerField( $args )
	{
		$name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
		$value = isset($input[$name]) ? $input[$name] : '#FF9800';
		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required>';
    }
}