<?php

class AdminMenu
{

    protected $current_tab;
    protected $menu_tabs;
    protected $validated = false;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'render_admin_menu'));
    }

    public function render_admin_menu(): void
    {
        add_menu_page(
            'Pushbullet Configurator',
            'Pushbullet',
            'manage_options',
            'pushbullet-configurator',
            array($this, 'render_admin_page'),
            'dashicons-admin-generic',
            100
        );

        add_submenu_page(
            null,
            'Pushbullet Configurator',
            'Settings',
            'read',
            'notify',
            array($this, 'init_tasks')
        );
    }

    public function render_admin_page(): void
    {
        $this->set_menu_tabs();
        $this->render_page();
    }

    public function init_tasks(): void
    {
        // TODO: Implement init_tasks() method.
        $token = Settings_Service::find_token()->value;
        $message = Settings_Service::find_message()->value;
        $recipients = Settings_Service::find_phone_number()->value;

        echo "Token: " . $token . "<br>";
        echo "Message: " . $message . "<br>";
        echo "Recipients: " . $recipients . "<br>";

    }

    public function set_menu_tabs(): void
    {
        $this->menu_tabs = array(
            'access_token' => array(
                'title' => 'Configuration',
                'render_callback' => array('Admin_Settings', 'render_content'),
                'save_callback' => array('Admin_Settings', 'save')
            ),
            'devices' => array(
                'title' => 'Devices',
                'render_callback' => array('Admin_Devices', 'render_content')
            ),
            'pushes' => array(
                'title' => 'Pushes',
                'render_callback' => array('Admin_Pushes', 'render_content')
            ),
        );
    }

    public function render_tabs(): void
    {
        ?>
        <h2 class="nav-tab-wrapper">
            <?php

            foreach ($this->menu_tabs as $tab => $tab_data) {
                $active = $this->current_tab == $tab ? 'nav-tab-active' : '';
                $title = $tab_data['title'];
                echo "<a class='nav-tab {$active}' href='?page=pushbullet-configurator&tab={$tab}'>{$title}</a>";
            }

            ?>
        </h2>
        <?php
    }

    public function render_page(): void
    {
        $this->get_current_tab();

        if(isset($_POST['submit']))
        {
            $response = call_user_func($this->menu_tabs[$this->current_tab]['save_callback']);
            $this->validated = $response;
        }

        ?>

        <div class="wrap">
            <?php if($this->is_validated()) {
                echo "<div class='notice notice-success is-dismissible'><p>" . __('Settings saved') . "</p></div>";

            }?>
            <h2>Pushbullet Configurator</h2>
            <?php $this->render_tabs(); ?>
            <div>
                <div class="post-body">
                    <div class="postbox">
                        <div class="inside">
                            <?php call_user_func($this->menu_tabs[$this->current_tab]['render_callback']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
    }

    public function get_current_tab(): void
    {
        $this->current_tab = sanitize_text_field($_GET['tab'] ?? array_key_first($this->menu_tabs));
    }

    public function is_validated(): bool
    {
        return $this->validated;
    }
}