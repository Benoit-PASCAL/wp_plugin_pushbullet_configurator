<?php

if (!class_exists("WP_List_Table")) {
    require_once ABSPATH . "wp-admin/includes/class-wp-list-table.php";
}

class Devices_List extends WP_List_Table {

    public function __construct($args = array())
    {
        parent::__construct(
            array(
                "singular" => __("Device"),
                "plural" => __("Devices")
            )
        );
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
            'nickname' => 'Nickname',
            'active' => 'Active',
            'icon' => 'Icon',
            'manufacturer' => 'Manufacturer',
            'model' => 'Model',
            'app_version' => 'App Version',
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
        ];
    }

    public function usort_reorder($a, $b)
    {
        $orderBy = (!empty($_GET['orderby'])) ? $_GET['orderby'] : "id";
        $order = (!empty($_GET['order'])) ? $_GET['order'] : "desc";
        $result = strcmp($a->$orderBy, $b->$orderBy); // on compare les deux valeurs
        return ($order === "asc") ? $result : -$result; // on retourne le résultat si asc sinon on inverse le résultat
    }

    public function column_default($item, $column_name): string
    {
        switch ($column_name) {
            case 'device':
            case 'active':
            case 'created':
            case 'modified':
            case 'icon':
            case 'nickname':
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
                return $item[$column_name] ?? '';
                break;
            default:
                return print_r($item, true);
        }
    }

    public function get_sortable_columns(): array
    {
        return [
            'active' => ['active', true],
            'created' => ['created', true],
            'modified' => ['modified', true],
            'icon' => ['icon', true],
            'nickname' => ['nickname', true],
            'generated_nickname' => ['generated_nickname', true],
            'manufacturer' => ['manufacturer', true],
            'model' => ['model', true],
            'app_version' => ['app_version', true],
            'fingerprint' => ['fingerprint', true],
            'key_fingerprint' => ['key_fingerprint', true],
            'push_token' => ['push_token', true],
            'has_sms' => ['has_sms', true],
            'type' => ['type', true],
            'kind' => ['kind', true],
            'remote_files' => ['remote_files', true],
            'iden' => ['iden', true],
        ];
    }

    public function column_cb($item): string
    {
        $item = (array)$item;

        return sprintf(
            '<input type="checkbox" name="delete-data[]" value="%s" />',
            $item['id']
        );
    }

    public function get_bulk_actions(): array
    {
        return [
            "update-data" => __("Update")
        ];
    }
}