<?php
/**
 * @package KaTiSoft Plugin
 *
 */
namespace Inc;

final class Init
{
    /**
     * Store all the classes inside an array
     * @return array Full list of classes
     */
    public static function get_services()
    {
        return [
            Pages\Dashboard::class,
			Base\Enqueue::class,
			Base\SettingsLinks::class,
			Base\CustomPostTypeController::class,
			Base\CustomTaxonomyController::class,
			Base\WidgetController::class,
			Base\TestimonialController::class,
			Base\AuthController::class,
			// Base\MembershipController::class,
            // Base\ChatController::class,
            Base\GutenburgController::class,
            Base\MailSMTPController::class,
            Base\AloPhoneController::class,
            Base\BackToTopController::class,
            Base\CustomLoginPageController::class,
            Base\ChatFacebookController::class
        ];
    }

    /**
     * Loop throught the classes, initialize them,
     * and all the register() method if it exists
     * @return 
     */
    public static function register_services() 
    {
        foreach ( self::get_services() as $class ) {
            $service = self::instantiate( $class );
            if ( method_exists( $service, 'register' ) ) {
                $service->register();
            }
        }
    }

    /**
     * Initialize the class
     * @param class $class     class from the services array
     * @return class instance  new instance of the class
     */
    private static function instantiate( $class )
    {
        return new $class();
    }

    // public static function katisoft_change_footer_admin(){
    //     add_filter('admin_footer_text', function(){
    //         echo '<span id="footer-thankyou">Thank you for creating with Katisoft. Developed by <a href="https://webdepnhatrang.com" target="_blank">Katisoft</a></span>';
    //     });
    // }

    public static function katisoft_remove_logo_admin_bar() {
        add_action( 'wp_before_admin_bar_render', function() {
            global $wp_admin_bar;
            $wp_admin_bar->remove_menu( 'wp-logo' );
        }, 0 );
    }
 
    /**
     * Load plugin textdomain.
     */
    public static function katisoft_load_textdomain() {
        add_action( 'plugins_loaded', function() {
            load_plugin_textdomain( 'katisoft', false, plugin_basename( dirname( __FILE__, 3 ) . '/languages' ) ); 
        });
        
    }
    
}