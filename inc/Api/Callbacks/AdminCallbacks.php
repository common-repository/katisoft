<?php
/**
 * @package Katisoft Plugin
 */
namespace Inc\Api\Callbacks;

use \Inc\Base\BaseController; 

class AdminCallbacks extends BaseController
{
    public function adminDashboard()
    {
        return require_once( "$this->plugin_path/templates/admin.php" );
    }

    public function adminCPT()
    {
        return require_once( "$this->plugin_path/templates/cpt.php" );
    }

    public function adminTaxonomy()
    {
        return require_once( "$this->plugin_path/templates/taxonomy.php" );
    }

    public function adminMailSMTP()
    {
        return require_once( "$this->plugin_path/templates/mail-smtp.php" );
    }

    public function adminAloPhone()
    {
        return require_once( "$this->plugin_path/templates/alo-phone.php" );
    }

    public function adminBackToTop()
    {
        return require_once( "$this->plugin_path/templates/back-to-top.php" );
    }

    public function adminCustomLoginPage()
    {
        return require_once( "$this->plugin_path/templates/custom-login-page.php" );
    }

    public function adminChatFacebook()
    {
        return require_once( "$this->plugin_path/templates/chat-facebook.php" );
    }
}