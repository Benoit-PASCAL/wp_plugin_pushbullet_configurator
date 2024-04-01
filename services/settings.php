<?php

if (!defined('ABSPATH')) {
    exit; 
}

class Settings_Service
{
    public static function create_db(): void
    {
        global $wpdb;

        $wpdb->query(
            "CREATE TABLE IF NOT EXISTS {$wpdb->prefix}pushbullet_config (
            id INT AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(250) NOT NULL,
            `value` VARCHAR(250) NOT NULL,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )"
        );

        self::init_db();
    }

    public static function init_db(): void
    {
        global $wpdb;
        $settings = ['token', 'phone_number', 'message', 'default_device', 'default_alert_type'];
        foreach ($settings as $setting) {
            $wpdb->insert("{$wpdb->prefix}pushbullet_config", ["name" => $setting]);
        }
    }

    public static function empty_db(): void
    {
        global $wpdb;
        $wpdb->query("TRUNCATE TABLE {$wpdb->prefix}pushbullet_config");
    }

    public static function delete_db(): void
    {
        global $wpdb;
        $wpdb->query("DROP TABLE {$wpdb->prefix}pushbullet_config");
    }

    public static function findAll(): array
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}pushbullet_config");
    }

    public static function find_token(): stdClass
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}pushbullet_config WHERE name = 'token'")[0];
    }

    public static function find_message(): stdClass
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}pushbullet_config WHERE name = 'message'")[0];
    }

    public static function find_phone_number(): stdClass
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}pushbullet_config WHERE name = 'phone_number'")[0];
    }

    public static function find_default_device(): stdClass
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}pushbullet_config WHERE name = 'default_device'")[0];
    }

    public static function find_default_alert_type(): stdClass
    {
        global $wpdb;
        return $wpdb->get_results("SELECT * FROM {$wpdb->prefix}pushbullet_config WHERE name = 'default_alert_type'")[0];
    }

    public static function set_default_device($iden): void
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "UPDATE {$wpdb->prefix}pushbullet_config SET value = %s WHERE name = 'default_device';",
            $iden);
        $wpdb->query($query);
    }

    public static function create($data): int
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "INSERT INTO {$wpdb->prefix}pushbullet_config (name, value) VALUES (%s, %s)",
            $data["name"],
            $data["value"]);
        $wpdb->query($query);
        return $wpdb->insert_id;


        return 0;
    }

    public static function update($name, $data): void
    {
        global $wpdb;

        $query = $wpdb->prepare(
            "UPDATE {$wpdb->prefix}pushbullet_config SET value = %s WHERE name = %s;",
            $data["value"],
            $name);
        $wpdb->query($query);
    }

    public static function delete_data($ids): void
    {
        global $wpdb;

        if(!is_array($ids)) {
            $ids = [$ids];
        }

        $wpdb->query("DELETE FROM {$wpdb->prefix}pushbullet_config WHERE id IN (" . implode(',', $ids) . ")");
    }
}