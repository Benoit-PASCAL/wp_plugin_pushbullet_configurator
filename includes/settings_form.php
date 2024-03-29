<?php

class Settings_Form {

    public array $items;
    protected array $device_options;

    public function __construct()
    {

    }

    public function prepare_items(): void
    {
        $data = Settings_Service::findAll();

        $this->device_options = [];
        foreach (Devices_Service::findAll() as $device) {
            if(property_exists($device, 'has_sms')) {
                $this->device_options[$device->iden] = $device->nickname;
            }
        }

        $this->items = array_filter($data, array($this, 'filter_item'));
    }

    public function filter_item($item): bool
    {
        return in_array($item->name, array_keys($this->get_inputs()));
    }

    public function get_label($item)
    {
        foreach ($this->get_inputs() as $key => $input) {
            if ($key == $item->name) {
                echo $input['label'];
            }
        }
    }

    public function get_input_name($item)
    {
        echo $item->name;
    }

    public function get_description($item)
    {
        foreach ($this->get_inputs() as $key => $input) {
            if ($key == $item->name) {
                echo $input['help'];
            }
        }
    }

    public function has_description($item): bool
    {
        foreach ($this->get_inputs() as $key => $input) {
            if ($key == $item->name) {
                return $input['help'] !== null;
            }
        }

        return false;
    }

    public function get_input_main_type($item)
    {
        foreach ($this->get_inputs() as $key => $input) {
            if ($key == $item->name) {
                if($input['type'] == 'select') {
                    return 'select';
                }
            }
        }

        return 'input';
    }

    public function get_input_type($item)
    {
        foreach ($this->get_inputs() as $key => $input) {
            if ($key == $item->name) {
                echo $input['type'];
            }
        }
    }

    public function get_select_options($item)
    {
        foreach ($this->get_inputs() as $key => $input) {
            if ($key == $item->name && $input['type'] == 'select') {
                if(count($input['options']) < 1) {
                    echo "<option value='' selected disabled>No options available</option>";
                } else {
                    echo $item->value == '' ? '<option selected disabled>' . __('No option selected', 'pushbullet-configurator') . '</option>' : '';

                    foreach ($input['options'] as $option_key => $option_value) {
                        $selected = $option_key == $item->value ? 'selected' : '';
                        echo "<option value='{$option_key}' {$selected}>{$option_value}</option>";
                    }
                }
            }
        }
    }

    public function get_inputs(): array
    {
        return [
            'token' => [
                'label' => 'Access token',
                'help' => 'You can create an Access Token on your <a href="https://www.pushbullet.com/#settings/account" target="_blank">Pushbullet account page</a>.',
                'type' => 'password',
            ],
            'phone_number' => [
                'label' => 'Phone number',
                'type' => 'text',
                'help' => 'Phone number that wil receive SMS'
            ],
            'message' => [
                'label' => 'Message',
                'type' => 'text',
                'help' => 'Message to send when an event is triggered'
            ],
            'default_device' => [
                'label' => 'Default device',
                'type' => 'select',
                'options' => $this->device_options,
                'help' => 'The device that will send the SMS'
            ],
            'default_alert_type' => [
                'label' => 'Default alert type',
                'type' => 'select',
                'options' => [
                    'sms' => 'SMS',
                    'push' => 'Push'
                ],
                'help' => 'The type of alert that will be sent'
            ]
        ];
    }


}