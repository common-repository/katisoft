<?php
/**
 * @package KaTiSoft Plugin
 *
 */
namespace Inc\Pages;

use \Inc\Base\BaseController;
use \Inc\Api\SettingsApi;
use \Inc\Api\Callbacks\AdminCallbacks;
use \Inc\Api\Callbacks\ManagerCallbacks;

class Dashboard extends BaseController
{
    public $settings;

    public $callbacks;

    public $callbacks_mngr;

    public $pages = array();

    public function register()
    {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->callbacks_mngr = new ManagerCallbacks();

        $this->setPages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages( $this->pages )->withSubPage( 'Dashboard' )->register();
    }

    public function setPages()
    {
        $this->pages = array(
            array(
                'page_title' => 'KaTiSoft Plugin',
                'menu_title' => 'KaTiSoft Plugin',
                'capability' => 'manage_options',
                'menu_slug' => 'katisoft_plugin',
                'callback' => array( $this->callbacks, 'adminDashboard' ),
                'icon_url' => 'dashicons-admin-plugins',
                'position' => 110
            )
        );
    }

    public function setSettings()
    {
        $args = array(
            array(
                'option_group' => 'katisoft_plugin_settings',
                'option_name' => 'katisoft_plugin',
                'callback' => array( $this->callbacks_mngr, 'checkboxSanitize' )
            )
        );

        $this->settings->setSettings( $args );
    }

    public function setSections()
    {
        $args = array(
            array(
                'id' => 'katisoft_admin_index',
                'title' => 'Settings Manager',
                'callback' => array( $this->callbacks_mngr, 'adminSectionManager' ),
                'page' => 'katisoft_plugin'
            )
        );

        $this->settings->setSections( $args );
    }

    public function setFields()
    {
        $args = array();

        foreach ( $this->managers as $key => $value ) {
            $args[] = array(
                'id' => $key,
                'title' => $value,
                'callback' => array( $this->callbacks_mngr, 'checkboxField' ),
                'page' => 'katisoft_plugin',
                'section' => 'katisoft_admin_index',
                'args' => array(
                    'option_name' => 'katisoft_plugin',
                    'label_for' => $key,
                    'class' => 'ui-toggle'
                )
            );
        }

        $this->settings->setFields( $args );
    }
}