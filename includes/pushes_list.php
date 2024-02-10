<?php

if (!class_exists("WP_List_Table")) {
    require_once ABSPATH . "wp-admin/includes/class-wp-list-table.php";
}

class Pushes_List extends WP_List_Table {

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

        $data = Pushes_Service::findAll();
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
            'title' => 'Title',
            'body' => 'Body',
        ];
    }

    public function get_hidden_columns(): array
    {
        return [
            'iden' => 'Iden',
            'active' => 'Active',
            'created' => 'Created',
            'modified' => 'Modified',
            'type' => 'Type',
            'dismissed' => 'Dismissed',
            'guid' => 'Guid',
            'direction' => 'Direction',
            'sender_iden' => 'Sender Iden',
            'sender_email' => 'Sender Email',
            'sender_email_normalized' => 'Sender Email Normalized',
            'sender_name' => 'Sender Name',
            'receiver_iden' => 'Receiver Iden',
            'receiver_email' => 'Receiver Email',
            'receiver_email_normalized' => 'Receiver Email Normalized',
            'target_device_iden' => 'Target Device Iden',
            'source_device_iden' => 'Source Device Iden',
            'client_iden' => 'Client Iden',
            'channel_iden' => 'Channel Iden',
            'awake_app_guids' => 'Awake App Guids',
            'url' => 'Url',
            'file_name' => 'File Name',
            'file_type' => 'File Type',
            'file_url' => 'File Url',
            'image_url' => 'Image Url',
            'image_width' => 'Image Width',
            'image_height' => 'Image Height'
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
            case 'title':
                return sprintf(
                    '<a href="%s">%s</a>
                            <div class="row-actions">
                                <span class="delete">
                                    <a
                                        href="%s"
                                        aria-label="Delete push">
                                            Delete
                                    </a>
                                </span>
                            </div>',
                    $_SERVER['REQUEST_URI'] . '&action=edit&iden=' . $item['iden'],
                    $item[$column_name] ?? '',
                    $_SERVER['REQUEST_URI'] . '&action=edit&iden=' . $item['iden'],
                    $_SERVER['REQUEST_URI'] . '&action=delete&iden=' . $item['iden']

                );
                break;
            case 'body':
                return $item[$column_name] ?? '';
                break;
            default:
                return 'No value';
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