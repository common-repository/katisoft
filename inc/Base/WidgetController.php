<?php 
/**
 * @package  KatisoftPlugin
 */
namespace Inc\Base;
use Inc\Base\BaseController;
use Inc\Api\Widgets\MediaWidget;
/**
* 
*/
class WidgetController extends BaseController
{
	public function register()
	{
		if ( ! $this->activated( 'widget_manager' ) ) return;
		$media_widget = new MediaWidget();
		$media_widget->register();
	}
}