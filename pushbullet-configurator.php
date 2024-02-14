<?php
/*

Plugin Name: Pushbullet Configurator
Description: A plugin to link any Pushbullet account to your WordPress website.
Author: Benoît PASCAL
Version: 1.0

Author URI: http://www.p-ben.com
Requires at least: 6.2
Requires PHP: 7.4

*/

class PushbulletPlugin
{
    public function __construct()
    {
        $this->init();
    }

    private function init()
    {
        define('PUSHBULLET_PLUGIN_DIR', plugin_dir_path(__FILE__));

        $this->get_services();
        $this->get_includes();
        $this->get_admin();

        // Plugin activation
        register_activation_hook(__FILE__, array('Settings_Service', 'create_db'));

        // Plugin deactivation
        register_deactivation_hook(__FILE__, array('Settings_Service', 'empty_db'));

        // Plugin uninstall
        register_uninstall_hook(__FILE__, array('Settings_Service', 'delete_db'));

        // Add shortcode to track forms
        add_shortcode('pushbullet_tracker', array('Tracking_Service', 'track_form'));

        // Add API routes
        new Tracking_Service();

        if(is_admin()) {
            new AdminMenu();
        }
    }

    private function get_admin(): void
    {
        require_once PUSHBULLET_PLUGIN_DIR . 'admin/admin_settings.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'admin/admin_devices.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'admin/admin_pushes.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'admin/admin.php';
    }

    private function get_services(): void
    {

        require_once PUSHBULLET_PLUGIN_DIR . 'services/settings.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'services/user.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'services/devices.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'services/pushes.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'services/texts.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'services/tracking.php';
    }

    private function get_includes(): void
    {
        require_once PUSHBULLET_PLUGIN_DIR . 'includes/settings_form.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'includes/devices_list.php';
        require_once PUSHBULLET_PLUGIN_DIR . 'includes/pushes_list.php';
    }
}

new PushbulletPlugin();