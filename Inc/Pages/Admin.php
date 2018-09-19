<?php
/**
 * @package  ClientsdeskPlugin
 */

namespace Inc\Pages;

use Inc\Api\SettingsApi;
use Inc\Base\BaseController;
use Inc\Api\Callbacks\AdminCallbacks;

/**
 *
 */
class Admin extends BaseController
{
    public $settings;

    public $callbacks;

    public $pages = [];

    public $subpages = [];

    public function register()
    {
        $this->settings = new SettingsApi();

        $this->callbacks = new AdminCallbacks();

        $this->setPages();

        $this->setSubpages();

        $this->setSettings();
        $this->setSections();
        $this->setFields();

        $this->settings->addPages($this->pages)->withSubPage('Dashboard')->addSubPages($this->subpages)->register();
    }

    public function setPages()
    {
        $this->pages = [
            [
                'page_title' => 'ClientsDesk',
                'menu_title' => 'ClientsDesk',
                'capability' => 'manage_options',
                'menu_slug' => 'clientsdesk_dashboard',
                'callback' => [$this->callbacks, 'adminDashboard'],
                'icon_url' => 'data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB3aWR0aD0iODAiIGhlaWdodD0iODAiIHZpZXdCb3g9IjAgMCA4MCA4MCI+PHN0eWxlPi5zdDB7ZmlsbDp1cmwoI1NWR0lEXzFfKX0uc3Qxe2ZpbGw6I2ZmZn08L3N0eWxlPjxsaW5lYXJHcmFkaWVudCBpZD0iU1ZHSURfMV8iIGdyYWRpZW50VW5pdHM9InVzZXJTcGFjZU9uVXNlIiB4MT0iNi4xOTgiIHkxPSI2LjE5OCIgeDI9IjczLjgwMiIgeTI9IjczLjgwMiI+PHN0b3Agb2Zmc2V0PSIwIiBzdG9wLWNvbG9yPSIjZmZjNjM5Ii8+PHN0b3Agb2Zmc2V0PSIuMzYiIHN0b3AtY29sb3I9IiNmZmFiNDUiLz48c3RvcCBvZmZzZXQ9IjEiIHN0b3AtY29sb3I9IiNmZjcyNWYiLz48L2xpbmVhckdyYWRpZW50PjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0yMS4yIDgwaDM3LjdDNzAuNSA4MCA4MCA3MC41IDgwIDU4LjhWMjEuMkM4MCA5LjUgNzAuNSAwIDU4LjggMEgyMS4yQzkuNSAwIDAgOS41IDAgMjEuMnYzNy43QzAgNzAuNSA5LjUgODAgMjEuMiA4MHoiLz48cGF0aCBjbGFzcz0ic3QxIiBkPSJNMjcuOSA0MmMtMS44LTIuNS0yLjgtNS42LTIuOC04LjkgMC0zLjMgMS02LjQgMi44LTguOSAyLjgtMy45IDcuNC02LjUgMTIuNi02LjUgNSAwIDkuNSAyLjQgMTIuMyA2LjEuMi4yLjEuNi0uMS44TDQ2LjMgMjljLS4yLjItLjYuMS0uNy0uMS0xLjItMS41LTMtMi40LTUuMS0yLjQtMi4yIDAtNC4yIDEuMS01LjQgMi44LS44IDEuMS0xLjIgMi40LTEuMiAzLjhzLjQgMi43IDEuMiAzLjhjLjIuMy41LjcuOC45IDEuMiAxLjIgMi44IDEuOSA0LjYgMS45aC4xYzIgMCAzLjgtMSA1LTIuNC4yLS4yLjUtLjMuNy0uMWw2LjMgNC41Yy4zLjIuMy41LjEuOC0yLjggMy43LTcuMiA2LjEtMTIuMiA2LjFoLS4xYy00LjIgMC04LjEtMS43LTEwLjgtNC40LS42LS43LTEuMi0xLjQtMS43LTIuMnptMzIuOCA1LjRjLS4yLS4yLS42LS4xLS44LjEtLjcuOS0xLjQgMS43LTIuMSAyLjUtNC41IDQuNi0xMC43IDcuMy0xNy4zIDcuMy0xLjMgMC0yLjYtLjEtMy45LS4zLTMuNC0uNi02LjYtMS44LTkuNC0zLjYtMS40LS45LTIuNy0yLTMuOS0zLjEtMS41LTEuNS0yLjgtMy4xLTMuOC00LjktLjItLjMtLjUtLjQtLjgtLjJsLTYuMyA0LjRjLS4yLjItLjMuNS0uMi43LjQuNi43IDEuMiAxLjEgMS43IDEuMSAxLjYgMi40IDMgMy43IDQuNCAxLjYgMS42IDMuNCAzIDUuMyA0LjMgNS4yIDMuNCAxMS40IDUuMyAxOCA1LjNoLjFDNTEuMyA2NiA2MSA2MC42IDY3IDUyLjRjLjItLjIuMS0uNi0uMS0uOGwtNi4yLTQuMnoiLz48L3N2Zz4=',
                'position' => 110
            ]
        ];
    }

    public function setSubpages()
    {
        $this->subpages = [
            [
                'parent_slug' => 'clientsdesk_dashboard',
                'page_title' => 'ClientsDesk Settings',
                'menu_title' => 'Settings',
                'capability' => 'manage_options',
                'menu_slug' => 'clientsdesk_settings',
                'callback' => [$this->callbacks, 'adminSettings']
            ]
        ];
    }

    public function setSettings()
    {
        $args = [
            [
                'option_group' => 'clientsdesk_options_group',
                'option_name' => 'clientsdesk_api_key',
                'callback' => [$this->callbacks, 'clientsdeskOptionsGroup']
            ],
            [
                'option_group' => 'clientsdesk_options_group',
                'option_name' => 'clientsdesk_api_signature'
            ]
        ];
        $this->settings->setSettings($args);
    }

    public function setSections()
    {
        $args = [
            [
                'id' => 'clientsdesk_admin_index',
                'title' => 'Settings',
                'callback' => [$this->callbacks, 'clientsdeskAdminSection'],
                'page' => 'clientsdesk_settings'
            ]
        ];
        $this->settings->setSections($args);
    }

    public function setFields()
    {
        $args = [
            [
                'id' => 'clientsdesk_api_key',
                'title' => 'API Key',
                'callback' => [$this->callbacks, 'clientsdeskApiKey'],
                'page' => 'clientsdesk_settings',
                'section' => 'clientsdesk_admin_index',
                'args' => [
                    'label_for' => 'clientsdesk_api_key',
                    'class' => 'api_key-class'
                ]
            ],
            [
                'id' => 'clientsdesk_api_signature',
                'title' => 'Signature',
                'callback' => [$this->callbacks, 'clientsdeskApiSignature'],
                'page' => 'clientsdesk_settings',
                'section' => 'clientsdesk_admin_index',
                'args' => [
                    'label_for' => 'clientsdesk_api_signature',
                    'class' => 'api_signature-class'
                ]
            ]
        ];
        $this->settings->setFields($args);
    }
}