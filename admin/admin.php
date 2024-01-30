<?php

class AdminMenu
{

    protected $current_tab;
    protected $menu_tabs;

    public function __construct()
    {
        add_action('admin_menu', array($this, 'render_admin_menu'));
    }

    public function render_admin_menu()
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
    }

    public function render_admin_page()
    {
        $this->set_menu_tabs();
        $this->render_page();
    }

    public function set_menu_tabs()
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
        );
    }

    public function render_tabs()
    {
        ?>
        <h2 class="nav-tab-wrapper">
            <?php

            foreach ($this->menu_tabs as $tab => $tab_data) {
                $active = $this->current_tab == $tab ? 'nav-tab-active' : '';
                //echo $tab;
                $title = $tab_data['title'];
                echo "<a class='nav-tab {$active}' href='?page=pushbullet-configurator&tab={$tab}'>{$title}</a>";
            }

            ?>
        </h2>
        <?php
    }

    public function render_page()
    {
        $this->get_current_tab();

        if(isset($_POST['submit']))
        {
            call_user_func($this->menu_tabs[$this->current_tab]['save_callback']);
        }

        ?>

        <div class="wrap">
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

    public function get_current_tab()
    {
        $this->current_tab = sanitize_text_field($_GET['tab'] ?? array_key_first($this->menu_tabs));
    }
}