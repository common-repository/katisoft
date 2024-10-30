<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Api\Callbacks;
class CustomLoginPageCallbacks
{
	public function customLoginPageSectionManager()
	{
		echo 'Create a WordPress Custom Login Page';
    }

    public function customLoginPageSanitize( $input )
    {
        return $input;
    }

    public function colorPickerField( $args )
	{
		$name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
		$value = isset($input[$name]) ? $input[$name] : '#f1f1f1';
		echo '<input type="text" class="regular-text" id="' . $name . '" name="' . $option_name . '[' . $name . ']" value="' . $value . '" placeholder="' . $args['placeholder'] . '" required>';
    }

    public function uploadBgImageField( $args ){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        $value = isset($input[$name]) ? $input[$name] : '';
        // Print HTML field
        $html = '<div class="upload">';
        $html .='    <input type="hidden" name="' . $option_name . '[' . $name . ']" id="' . $name . '" value="' . $value . '" />';
        $html .='    <button type="button" class="js-upload-bg-login-page button button-primary">Select Image</button>';
        $html .='    <button type="button" class="js-remove-bg-login-page button">Remove Image</button>';
        $html .= '   <br><img class="preview-background" src="'. $value .'" style="max-width: 300px;" />';
        $html .='</div>';

        echo $html;
    }

    public function uploadLogoImageField( $args ){
        $name = $args['label_for'];
        $option_name = $args['option_name'];
        $input = get_option( $option_name );
        $value = isset($input[$name]) ? $input[$name] : '';
        // Print HTML field
        $html = '<div class="upload">';
        $html .='    <input type="hidden" name="' . $option_name . '[' . $name . ']" id="' . $name . '" value="' . $value . '" />';
        $html .='    <button type="button" class="js-upload-logo-login-page button button-primary">Select Image</button>';
        $html .='    <button type="button" class="js-remove-logo-login-page button">Remove Image</button>';
        $html .= '   <br><img class="preview-logo" src="'. $value .'" style="max-width: 300px;" />';
        $html .='</div>';

        echo $html;
    }
}