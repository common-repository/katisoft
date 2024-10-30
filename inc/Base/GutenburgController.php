<?php 
/**
 * @package  Katisoft Plugin
 */
namespace Inc\Base;
use Inc\Base\BaseController;
use Inc\Api\GutenburgBlocks\CallToActionBlock;
/**
* 
*/
class GutenburgController extends BaseController
{
    public function register()
	{
        if ( ! $this->activated( 'gutenburg_manager' ) ) return;
        $cta_blocks = new CallToActionBlock();
        $cta_blocks->register();
    }
}