<?php

if (!defined('ABSPATH')) {
    exit; 
}

if (!class_exists("WP_List_Table")) {
    require_once ABSPATH . "wp-admin/includes/class-wp-list-table.php";
}

class Devices_List extends WP_List_Table {

    private $default_device;
    public function __construct($args = array())
    {
        parent::__construct(
            array(
                "singular" => __("Device"),
                "plural" => __("Devices")
            )
        );

        $this->default_device = Settings_Service::find_default_device();
    }

    /**
     * @throws \WpOrg\Requests\Exception
     */
    public function prepare_items(): void
    {
        $columns = $this->get_columns();
        $hidden = $this->get_hidden_columns();
        $sortable = $this->get_sortable_columns();

        $perPage = $this->get_items_per_page("devices_per_page", 10);
        $currentPage = $this->get_pagenum();


        $data = Devices_Service::findAll();
        $totalPage = count($data);

        usort($data, array(&$this, "usort_reorder"));

        $paginationData = array_slice($data, (($currentPage - 1) * $perPage), $perPage);

        $this->set_pagination_args(
            array(
                "total_items" => $totalPage,
                "per_page" => $perPage
            )
        );

        $this->_column_headers = array($columns, $hidden, $sortable);
        $this->items = $paginationData;
    }

    public function get_columns(): array
    {
        return [
            'nickname' => __('Nickname', 'pushbullet-configurator'),
            'model' => __('Model', 'pushbullet-configurator'),
            'sms_friendly' => __('Can send SMS', 'pushbullet-configurator'),
        ];
    }

    public function get_hidden_columns(): array
    {
        return [
            'created' => 'Created',
            'modified' => 'Modified',
            'fingerprint' => 'Fingerprint',
            'key_fingerprint' => 'Key Fingerprint',
            'push_token' => 'Push Token',
            'has_sms' => 'Has SMS',
            'type' => 'Type',
            'kind' => 'Kind',
            'remote_files' => 'Remote Files',
            'iden' => 'Iden',
            'icon' => 'Icon',
            'app_version' => 'App Version',
            'active' => 'Active',
            'manufacturer' => 'Manufacturer',
        ];
    }

    public function usort_reorder($a, $b)
    {
        $orderBy = (!empty($_GET['orderby'])) ? $_GET['orderby'] : "id";
        $order = (!empty($_GET['order'])) ? $_GET['order'] : "desc";
        $result = strcmp($a->$orderBy, $b->$orderBy);
        return ($order === "asc") ? $result : -$result;
    }

    public function column_default($item, $column_name): string
    {
        switch ($column_name) {
            case 'nickname':
                return $this->get_nickname_template($item);
                break;
            case 'sms_friendly':
                return property_exists($item, 'has_sms') ? __('Yes') : __('No');
            case 'device':
            case 'active':
            case 'created':
            case 'modified':
            case 'icon':
            case 'generated_nickname':
            case 'manufacturer':
            case 'model':
            case 'app_version':
            case 'fingerprint':
            case 'key_fingerprint':
            case 'push_token':
            case 'has_sms':
            case 'type':
            case 'kind':
            case 'remote_files':
            case 'iden':
                return $item->$column_name ?? '';
                break;
            default:
                return 'No value';
        }
    }

    public function get_sortable_columns(): array
    {
        return [
            'nickname' => ['nickname', true],
            'model' => ['model', true],
            'sms_friendly' => ['has_sms', true],
        ];
    }

    public function get_nickname_template($item)
    {
        $iden = $item->iden;
        $label_text = $item->nickname ?? '';
        $link = $_SERVER['REQUEST_URI'] . '&action=use&iden=' . $item->iden;
        $link_block = '
            <a
                href="' . $link . '"
                aria-label="Use ' . $label_text . ' as default device">
                    '. __('Use as default device to send SMS', 'pushbullet-configurator') .'
            </a>
        ';

        if($item->iden === $this->default_device->value) {
            $label_text .= ' (Selected as default device)';
            $link_block = __('Use as default device to send SMS', 'pushbullet-configurator');
        }

        if(!property_exists($item, 'has_sms')) {
            $link_block = __('Use as default device to send SMS', 'pushbullet-configurator');
        }


        return sprintf('
            <strong>
                <span>%s</span>
            </strong>
                <div class="row-actions">
                    <span class="">%s</span>
                </div>',
            $label_text,
            $link_block);
    }
}