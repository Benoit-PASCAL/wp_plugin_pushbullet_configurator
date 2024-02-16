<?php

if (!class_exists("WP_List_Table")) {
    require_once ABSPATH . "wp-admin/includes/class-wp-list-table.php";
}

class Pushes_List extends WP_List_Table {

    public function __construct($args = array())
    {
        parent::__construct(
            array(
                "singular" => __("Push"),
                "plural" => __("Pushes")
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
            'cb' => '<input type="checkbox" />',
            'title' => __('Title', 'pushbullet-configurator'),
            'body' => __('Body', 'pushbullet-configurator'),
            'created' => __('Created', 'pushbullet-configurator'),
            'modified' => __('Modified', 'pushbullet-configurator'),
        ];
    }

    public function get_hidden_columns(): array
    {
        return [
            'iden' => 'iden'
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
            case 'title':
                return sprintf(
                    '<strong>%s</strong>
                            <div class="row-actions">
                                <span class="delete">
                                    <a
                                        href="%s"
                                        aria-label="%s">
                                            %s
                                    </a>
                                </span>
                            </div>',
                    $item->$column_name ?? '',
                    $_SERVER['REQUEST_URI'] . '&action=delete&iden=' . $item->iden,
                    __('Delete push', 'pushbullet-configurator'),
                    __('Delete', 'pushbullet-configurator'),
                );
                break;
            case 'body':
                return $item->$column_name ?? '';
                break;
            case 'created':
            case 'modified':
                return date('d/m/Y H:i:s', $item->$column_name) ?? '';
                break;
            default:
                return __('No value', 'pushbullet-configurator');
        }
    }

    public function get_sortable_columns(): array
    {
        return [
            'title' => ['title', true],
            'body' => ['body', true],
            'created' => ['created', true],
            'modified' => ['modified', true],
        ];
    }

    public function column_cb($item): string
    {
        $item = (array)$item;

        return sprintf(
            '<input type="checkbox" name="iden[]" value="%s" />',
            $item['iden']
        );
    }

    public function get_bulk_actions(): array
    {
        return [
            "delete" => __("Delete")
        ];
    }
}