<?php
/**
 * @package KaTiSoft Plugin
 */
/*
Plugin Name: KaTiSoft
Plugin URI: https://webdepnhatrang.com/
Description: KaTiSoft Plugin được phát triển bởi KaTiSoft - Web Đẹp Nha Trang
Version: 1.0.6
Author: Thien Pham
Author URI: https://cv.khocoupon.net/
License: GPLv2 or later
Text Domain: katisoft
Domain Path: /languages/
*/

/*
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

Copyright 2005-2015 Automattic, Inc.
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Require once the composer autoload 
if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
    require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_katisoft_plugin(){
    Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_katisoft_plugin' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_katisoft_plugin(){
    Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_katisoft_plugin' );

if ( class_exists( 'Inc\\Init' ) ) {
    Inc\Init::register_services();

    // Remove logo admin bar
    Inc\Init::katisoft_remove_logo_admin_bar();

    // Load plugin textdomain.
    Inc\Init::katisoft_load_textdomain();
}