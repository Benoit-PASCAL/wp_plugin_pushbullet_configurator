# Pushbullet configurator plugin for WordPress

This plugin allows you to receive push notifications or SMS on your Android phone, using the Pushbullet service whenever a form is submitted on your WordPress site.

## Prerequisites

You need to have a Pushbullet account and an API key. 
You can get an account at https://www.pushbullet.com/ and generate an API key at https://www.pushbullet.com/#settings

## Installation

1. Upload the `pushbullet-configurator` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the Pushbullet Configurator settings page and enter your Pushbullet Token
4. Configure all other settings as you like
5. Save the settings 
6. Go to the Pushbullet Devices tab and select the device you want to use as default sender. (this device will also be the one that will receive the notifications by default)
7. Save the settings. 
8. Add the following shortcode on pages or post you want to track: `[pushbullet_tracker]`. 
9. You are ready to go!

## Usage

The plugin will send a notification to the device you selected as default sender, whenever a form is submitted on your site.

## Changelog

### 0.1

* Initial release
* Added Pushbullet API integration
* Added Pushbullet Devices integration
* Added Tracker shortcode