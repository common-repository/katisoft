<?php 
/**
 * @package  KatisoftPlugin
 */
namespace Inc\Api\GutenburgBlocks;
use \Inc\Base\BaseController; 
/**
* 
*/
class CallToActionBlock extends BaseController
{
    public function register()
	{
		add_action( 'init', array($this, 'katisoft_gutenberg_blocks') );
	}

    public function katisoft_gutenberg_blocks()
    {
        wp_register_script('custom-cta-js', $this->plugin_url . '/build/index.js', array( 'wp-blocks' ) );

        register_block_type( 'katisoft/custom-cta', array(
            'editor_script' => 'custom-cta-js'
        ) );
    }
}