<?php

class Admin_Pushes
{
    public function render_content(): void
    {
        if(isset($_GET['action']) || isset($_POST['action'])) {

            if($_GET['action'] == 'create' || $_POST['action'] == 'create') {
                if(isset($_POST['email']) && isset($_POST['title']) && isset($_POST['body']) && !empty($_POST['email']) && !empty($_POST['title']) && !empty($_POST['body'])) {
                    $email = sanitize_email($_POST['email']);
                    $title = sanitize_text_field($_POST['title']);
                    $body = sanitize_text_field($_POST['body']);

                    $data = array(
                        'email' => $email,
                        'type' => 'note',
                        'title' => $title,
                        'body' => $body
                    );

                    $response = Pushes_Service::create($data);
                    if(is_wp_error($response)) {
                        echo "<div class='notice notice-error is-dismissible'><p>" . $response->get_error_message() . "</p></div>";
                    } else {
                        echo "<div class='notice notice-success is-dismissible'><p>" . __('Push sent') . "</p></div>";
                    }
                } else {
                    if(isset($_POST['email']) && empty($_POST['email'])) {
                        echo "<div class='notice notice-error is-dismissible'><p>" . __('Email is required') . "</p></div>";
                    }

                    if(isset($_POST['title']) && empty($_POST['title'])) {
                        echo "<div class='notice notice-error is-dismissible'><p>" . __('Title is required') . "</p></div>";
                    }

                    if(isset($_POST['body']) && empty($_POST['body'])) {
                        echo "<div class='notice notice-error is-dismissible'><p>" . __('Body is required') . "</p></div>";
                    }

                    require_once PUSHBULLET_PLUGIN_DIR . 'templates/views/_pushes_create.php';
                    return;
                }
            }

            if($_GET['action'] == 'delete' || $_POST['action'] == 'delete') {
                if((isset($_GET['iden']) && !empty($_GET['iden'])) || (isset($_POST['iden']) && !empty($_POST['iden'])) ) {
                    $iden = $_POST['iden'] ?? sanitize_text_field($_GET['iden']);
                    Pushes_Service::delete($iden);
                    echo "<div class='notice notice-success is-dismissible'><p>" . __('Push deleted') . "</p></div>";
                } else {
                    echo "<div class='notice notice-error is-dismissible'><p>" . __('Error while trying to delete push') . "</p></div>";
                }
            }

        }

        $table = new Pushes_List();
        require_once PUSHBULLET_PLUGIN_DIR . 'templates/views/_pushes_list.php';
    }
}